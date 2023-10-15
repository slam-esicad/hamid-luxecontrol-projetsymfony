let locker = document.querySelector('.locker');

$('.locker').click(() => {
    $('.locker').toggleClass('unlocked')
    $('.locker i').toggleClass('open')
    $('form input').prop('disabled', (i, v) => !v)
    $('form textarea').prop('disabled', (i, v) => !v)
})