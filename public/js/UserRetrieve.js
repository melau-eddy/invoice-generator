var order = 'asc'
$('.column_sort').on('click', function () {
    $('.updown').remove()
    let column_name = $(this).attr('id')
    var arrow = ''
    if (order == 'desc' || order == undefined) {
        arrow = ''
        arrow = '<span class="updown fa fa-arrow-down"></span>'
        order = 'asc'
        console.log(order)

    } else {
        arrow = ''
        arrow = '<span class="updown fa fa-arrow-up"></span>'
        order = 'desc'
        console.log(order)
    }
    let element = document.getElementById('order')
    element.value = order
    var namefield = ''
    namefield += $(this).html()
    namefield += arrow
    console.log(namefield)
    $(this).html(namefield)

})

// function make_active(i) {
//     localStorage.setItem("id", i)
// }
//
// const a = localStorage.getItem("id")
// var id = document.getElementById(a)
// id.style.color = 'red';
// id.style.fontSize = "25px";


var queryString=window.location.search
const urlParams = new URLSearchParams(queryString);
var page=urlParams.get('page')
var id=document.getElementById(page)
id.classList.add('active')

