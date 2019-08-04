'use strict';

// Form validation
(function () {
  window.addEventListener('load', function () {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);

  $(window).ready(function () {
    if (localStorage.sidebar === 'a') {
      $('.c-bars').addClass('is-active');
      $('.c-sidebar').addClass('is-close');
      $('.main').addClass('is-close');
      $('.c-header').addClass('is-close');
    } else {
      $('.c-bars').removeClass('is-active');
      $('.c-sidebar').removeClass('is-close');
      $('.main').removeClass('is-close');
      $('.c-header').removeClass('is-close');
    }
  });

  $('.datetimepicker').datetimepicker({
    format: 'DD MMMM YYYY',
    useCurrent: true,
    defaultDate: new Date(),
    locale: 'id',
    icons: {
      time: 'fa fa-time',
      date: 'fa fa-calendar',
      up: 'fa fa-angle-up',
      down: 'fa fa-angle-down',
      previous: 'fa fa-angle-left',
      next: 'fa fa-angle-right',
      today: 'fa fa-screenshot',
      clear: 'fa fa-trash',
      close: 'fa fa-remove'
    }
  });

  var url = window.location.href.split('-')[1];
  $('.c-nav--item').each(function (el, item) {
    $(item).children('a').removeClass('is-active');
  });
  $('#' + url).children('a').addClass('is-active');

  $('.c-bars').click(function (e) {
    $(e.currentTarget).toggleClass('is-active');
    $('.c-sidebar').toggleClass('is-close');
    $('.main').toggleClass('is-close');
    $('.c-header').toggleClass('is-close');
    if ($(e.currentTarget).hasClass('is-active')) {
      localStorage.sidebar = 'a';
      tooltipSidebar();
    } else {
      localStorage.sidebar = 'b';
      tooltipSidebar();
    }
  });

  var tooltipSidebar = function tooltipSidebar() {
    $('[data-toggle="tooltip"]').tooltip(localStorage.sidebar === 'a' ? 'enable' : 'disable');
  };
  tooltipSidebar();

  $('.select2').select2({
    theme: 'bootstrap'
  });

  // Svg
  jQuery('img.svg').each(function (i, el) {
    var $img = jQuery(el);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function (data) {
      var $svg = jQuery(data).find('svg');
      if (typeof imgID !== 'undefined') {
        $svg = $svg.attr('id', imgID);
      }
      if (typeof imgClass !== 'undefined') {
        $svg = $svg.attr('class', imgClass + ' replaced-svg');
      }
      $svg = $svg.removeAttr('xmlns:a');
      $img.replaceWith($svg);
    }, 'xml');
  });
})();