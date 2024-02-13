let formProCheck = document.querySelector('.form-pro-check')

let showProInfos = () => {
    $('.form-pro-siret').show();
    $('.form-pro-bic').show()
}

let hideProInfos = () => {
    $('.form-pro-siret').hide()
    $('.form-pro-bic').hide()
}

formProCheck.addEventListener('change', () => {
    if($(formProCheck).is(':checked')) {
        showProInfos()
    } else {
        hideProInfos()
    }
})