var contactForm = {
  email   :   $('#emailLab input'),
  name    :   $('#nameLab input'),
  phone   :   $('#phoneLab input'),
  society :   $('#societyLab input'),
  reset   :   $('#contactForm input[type=reset]'),
  submit  :   $('#contactForm input[type=submit]'),
  form    :   $('#contactForm'),
  
  init: function() {
    this.email.blur(this.testEmail);
    this.editorCounterInit();
    this.form.submit(this.editorTest);
    $(this.form).find('[contenteditable=true]').keyup(this.editorCounter);
  },
  
  emailListen: function() {
    this.email.blur(this.testEmail);
  },
  
  submitListen: function() {
    this.form.submit(this.submitTest);
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
      $('#editorHelper').remove();
      $(MSGcontent).removeAttr('aria-describedby');
    }
  },
  
  editorCounterInit: function() {
    var editable = $('[contenteditable=true]');
    var container = $('.fr-toolbar.fr-desktop.fr-top.fr-basic.fr-sticky-off');
    var button = $(container).find('button:last-child').clone();
    var span = $(button).find('span');
    var charCount = $(editable).text().length;
    
    $(button).removeClass('fr-disabled');
    $(button).attr('id', 'myCharCounter');
    $(button).find('i').remove();
    $(button).attr('title', 'Char counter')
    
    $(span).attr('class', '');
    $(span).text(charCount);
    
    var color = (charCount < 10 ) ? 'red' : 'green';
    
    $(span).css('color', color);
    
    
    $(container).append($(button));  
  },
  
  editorCounter: function() {
    var editableLength = $('[contenteditable=true]').text().length;
    console.log(editableLength);
    var counter = $('#myCharCounter span');
    var color = (editableLength < 10 ) ? 'red' : 'green';
    
    $(counter).text(editableLength);
    $(counter).css('color', color);
    
  }
}


$(document).ready(function() {
  contactForm.init();
});