/*tabel*/

// $('#extent_tbl1, .mytabvle').DataTable();

/*tabel close*/

/*alert*/
	//$(".alert").fadeTo(4000, 500).slideUp(500, function(){
    //$(".alert").slideUp(500);
//});
/*alert close*/

/*tooltip*/
$("[data-toggle='tooltip']").tooltip();
/*tooltip close*/


/*nav*/

  $(function(){

        $('.main_nav .navbar-nav a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')

        $('.main_nav .navbar-nav a').click(function(){

            $(this).parent().addClass('active').siblings().removeClass('active')    

        })

    })

/*nav*/

/*slider1*/
$('#slider_galler2').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})
/*slider1*/

/*slider2*/
$('#slider_galler5').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
/*slider2*/

