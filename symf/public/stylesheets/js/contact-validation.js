var contactForm = {
  email   :   $('#emailLab input'),
  name    :   $('#nameLab input'),
  phone   :   $('#phoneLab input'),
  society :   $('#societyLab input'),
  subject :   $('#subjectLab input'),
  message :   $('#contactMSG'),
  reset   :   $('#contactForm input[type=reset]'),
  submit  :   $('#contactForm input[type=submit]'),
  form    :   $('#contactForm'),
  sent    :   $('#mailSent'),
  
  init: function() {
    this.email.blur(this.testEmail);
    this.editorCounterInit();
    this.form.submit(this.editorTest);
    $(this.form).find('[contenteditable=true]').keyup(this.editorCounter);
    this.reset.click(this.editorReset);
  },
  
  testEmail: function() {
    var value = $(this).val();
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var spanAlert = $('<span></span>');
    var parent = $(this).parent();
    var alertMsg = $(parent).find('span.alert');
    
    if (!regex.test(value) && alertMsg.length == 0) {
      
      $(spanAlert).addClass('help-text alert');
      $(spanAlert).html('Adresse de messagerie incorrecte :doit être selon le format <strong>adress@email.com');

      $(parent).addClass('callout alert');
      $(parent).append($(spanAlert));
      $(this).attr('data-success', 'false');
    } else if (regex.test(value)){
      $(this).attr('data-success', 'true');
      $(parent).find('span.alert').remove();
      $(parent).removeClass('callout alert');
    }
  },
  
  editorTest: function(e) {
    
    var label = $('#msgLab');
    var alert = $('<p></p>');
    $(alert).attr('id', 'editorHelper')
    var MSGcontent = $('[contenteditable=true]').text();
    
    
    if (MSGcontent.length < 10 && $('#editorHelper').length == 0) {
      e.preventDefault();
      
      $(alert).addClass('help-text alert');
      $(alert).html('Votre message doit contenir plus de dix caractères !!');
      $(alert).addClass('callout alert');
      $('#details').append($(alert));
      $(MSGcontent).attr('aria-describedby', 'editorHelper')
    } else if (MSGcontent.length > 10){
      e.preventDefault();
      
      $('#editorHelper').remove();
      $(MSGcontent).removeAttr('aria-describedby');
      
      
      var params = contactForm.paramsSerial($(e.target));
      
      
      
      $.ajax({
        type: 'POST',
        url: '/contact/new',
        data: JSON.stringify(params),
        contentType: 'application/json',
        async: true,
        success: function(response) {          
          $(contactForm.sent).html(response.response);
          $(contactForm.sent).attr('aria-hidden', 'false');
          $(contactForm.sent).attr('data-status', 'true');
          $(contactForm.sent).delay(5000).fadeOut('slow', function() {
            $(this).attr('aria-hidden', 'true');
            $(this).removeAttr('style');
          });          
        },
        error: function(response) {          
          var json = response.responseJSON;
          
          $(contactForm.sent).html(json.response);
          $(contactForm.sent).attr('aria-hidden', 'false');
          $(contactForm.sent).attr('data-status', 'false');
          $(contactForm.sent).delay(5000).fadeOut('slow', function() {
            $(this).attr('aria-hidden', 'true');
            $(this).removeAttr('style');
          });          
        }
      });
      
      $(contactForm.reset).trigger('click');
    }
  },
  
  editorCounterInit: function() {
    var editable = $('[contenteditable=true]');
    var span = $('#myCharCounter');
    var charCount = $(editable).text().length;
    var color = (charCount < 10 ) ? 'red' : 'green';
    
    $(span).text(charCount);
    $(span).css('color', color);

    
    
    // $(container).append($(button));
  },
  
  editorCounter: function() {
    var editableLength = $('[contenteditable=true]').text().length;
    var counter = $('#myCharCounter');
    var color = (editableLength < 10 ) ? 'red' : 'green';
    
    $(counter).text(editableLength);
    $(counter).css('color', color);
    
  },
  
  editorReset: function() {
    $(contactForm.message).val('');
    $('[contenteditable=true]').empty();
  },
  
  paramsSerial: function(target) {
    
    var params = {
      contact: {
        email: this.email.val(),
        subject: this.subject.val(),
        message: this.message.val(),
      },
      author: this.name.val(),
      phone: this.phone.val(),
      society: this.society.val()
    }
    
    return params;
  }
}


$(document).ready(function() {
  contactForm.init();
});