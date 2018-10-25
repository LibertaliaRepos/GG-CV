function timer() {
  var date = new Date();
  var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  
  var webTimer = {
    day : '',
    time : '',
    
    init : function() {
      this.day = date.toLocaleDateString('fr', options)
      var timeRegex = /\d{2}:\d{2}/;
      this.time = date.toLocaleTimeString('fr');      
    }
  }
  
  
  var websiteTimer = {
    dayElem : $('#ephemeris span[data-day]'),
    timeElem : $('#ephemeris span[data-time]'),
    
    getDayStr : function() {
      return $(this.dayElem).text();
    },
    getTimeStr : function() {
      return $(this.timeElem).text();
    },
    setDay : function(text) {
      $(this.dayElem).text(text);
    },
    setTime : function(text) {
      $(this.timeElem).text(text);
    }
  }
  
  webTimer.init();
  
  
  if (webTimer.day != websiteTimer.getDayStr()) {
    websiteTimer.setDay(webTimer.day);
  }
  
  if (webTimer.time != websiteTimer.getTimeStr()) {
    websiteTimer.setTime(webTimer.time);
  }
  
  setTimeout('timer()', 1000);
}

$(document).ready(timer);