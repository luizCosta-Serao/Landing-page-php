$(function() {
  if ($('target').length > 0) {
    const element = '#' + $('target').attr('target');
    const sectionScroll = $(element).offset().top;
    $('html, body').animate({'scrollTop': sectionScroll}, 2000, 'swing');
  }

  let currentSlide = 0;
  const maxSlide = $('.hero-bg').length - 1;

  initSlide();
  changeSlide();

  function initSlide() {
    $('.hero-bg').hide();
    $('.hero-bg').eq(0).show();
  }
  
  function changeSlide() {
    setInterval(function() {
      $('.hero-bg').eq(currentSlide).fadeOut()
      currentSlide++
      if (currentSlide > maxSlide) {
        currentSlide = 0;
      }
      $('.hero-bg').eq(currentSlide).fadeIn()
    }, 3000)
  }
})