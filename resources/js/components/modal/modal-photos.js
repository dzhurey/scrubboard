const modal = `<div id="modal-photos" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Photos <span id="counter"></span></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>`;

const sliderItem = (sliders) => {
  const slider = sliders.map((slider, i) => {
    return `<div class="carousel-item text-center ${i === 0 ? 'active' : ''}">
      <img src="${slider.path}" class="d-block mx-auto img-fluid" alt="${slider.updated_at}">
      <div class="mt-3">
        <small>Photo (${i + 1}) ${slider.updated_at}</small>
      </div>
    </div>`;
  });
  return slider.join('');
};

const makeSliderPhotos = (data) => {
  const modalBody = $('#modal-photos .modal-body');
  modalBody[0].insertAdjacentHTML('beforeend', `
    <div id="slider-photo" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">${sliderItem(data)}</div>
      <a class="carousel-control-prev" href="#slider-photo" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#slider-photo" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  `);
  $('#slider-photo').carousel({
    interval: 0,
    wrap: false,
  })
};

export default (data) => {
  $('.main')[0].insertAdjacentHTML('beforeend', modal);
  $('#counter').text(`(${data.length})`);
  $('#modal-photos').on('show.bs.modal', () => makeSliderPhotos(data));
  $('#modal-photos').on('hide.bs.modal', () => $('#slider-photo').remove());
};