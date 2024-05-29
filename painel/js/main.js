$(function() {
  let open = true;
  const windowSize = $(window).innerWidth()

  if (windowSize <= 768) {
    open = false;
  }

  $(window).resize(() => {
    if (windowSize <= 768) {
      open = false;
    }
  })
  console.log(open)

  $('.menu-btn').click(() => {
    if (open) {
      $('.menu, .content, header').removeClass('active')
      open = false;
    } else {
      $('.menu, .content, header').addClass('active')
      open = true
    }
  })
})

$('[actionBtn="delete"]').click(function() {
  const r = confirm('Deseja excluir o registro?');
  if (r === true) {
    return true
  } else {
    return false
  }
})