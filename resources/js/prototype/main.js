'use strict';

// Form validation
(() => {
  window.addEventListener('load', () => {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, (form) => {
      form.addEventListener('submit', (event) => {
        form.classList.remove('was-validated');
        removeError();
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          $('button[type="submit"]').attr('disabled', false);
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);

  const removeError = () => {
    const fields = $('.is-error');
    if (fields.length > 0) {
      fields.each((i, a) => {
        a.classList.remove('is-error');
      })
    }
  }

  $(window).ready(() => {
    if ($('.c-sidebar--logo .c-bars').is(':visible')) {
      $('.c-bars').addClass('is-active');
      $('.c-sidebar').addClass('is-close');
      $('.main').addClass('is-close');
			$('.c-header').addClass('is-close');

			localStorage.sidebar = 'a';
    }
    
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
    format: 'YYYY-MM-DD',
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
  $('#birth_date').val('');

  $('.c-bars').click((e) => {
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

  $('.form-control').each((idx, itm) => {
    if (itm.hasAttribute('required')) {
      const label = itm.parentElement.querySelector('label');
      if (label) {
        label.innerHTML += '<span style="color: red">&nbsp;*</span>';
      }
    }
  })

  const tooltipSidebar = () => {
    $('.c-nav--item[data-toggle="tooltip"]').tooltip(
      localStorage.sidebar === 'a' ? 'enable' : 'disable'
    );
  };

  $('.select2').select2({ 
    theme: 'bootstrap',
    placeholder: 'Choose option',
  });
  $('#is_same_address').change((e) => {
    const target = $('#is_same_address_content');
    e.target.checked ? target.hide() : target.show();
  });

  // Svg
  jQuery('img.svg').each((i, el) => {
    var $img = jQuery(el);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, (data) => {
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

  $('input[type="text"], input[type="number"]').each((i, item) => {
    $(item).attr('autocomplete', 'off');
  }); 
  $('form').attr('autocomplete', 'off');

  $('.btn-light[type="button"]').click(() => {
    const urlArray = window.location.href.split('/');
    const id = urlArray[3];
    const link = id === 'courier' ? `${id}/${urlArray[4]}` : id;
    window.location = `/${link}`;
  })
})();