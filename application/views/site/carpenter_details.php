<?php include_once('include/header.php'); ?>

<link rel="stylesheet" type="text/css" href="<?=site_url('assets/site/css/');?>jquery.fancybox.min.css">

<div class="innerer_banner">
  <div class="container">
    <div class="box_us16">
      <h1>Carpenter Service</h1>
    </div>
  </div>
</div>
<div class="box_us20 sec_pad">
  <div class="container">
    <div class="row">
      <div class="col-sm-10">
        <div class="box_us21">
          <div class="slider_gallery gallery">
            <div id="big" class="owl-carousel owl-theme">
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_1.jpg"><img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_1.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_2.jpg"><img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_2.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_3.jpg"><img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_3.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_4.jpg"><img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_4.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_4.jpg"><img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_1.jpg"></a>
                </div>
              </div>
            </div>
            <div id="thumbs" class="owl-carousel owl-theme">
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_1.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_2.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_3.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/carpenter/carpenter_4.jpg">
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>

          <div class="box_us15">
            <h3 class="details-heading">Carpenter Service</h3>
            <hr>
            <p>
              We provide Interior & Decorators service along with furniture manufacturing, customize furniture as per the customer's need and renovation of the old furnitures.
              <br/>
              Carpenter service with highly skilled labors with the help of most technological advanced machine. We promise to work in given time and does work on the customer's demand.
              <br/>
              We modify the current furniture. Our team of highly skilled Interior Decorators works in a way that customer fall in love with the renovation.
            </p>

            <h3 class="details-heading">
              Our carpenter work in Residential, commercial, industrial as below
            </h3>
            <hr>
            <p>
              Work station
              <br/>
              Office partition  (Gypsum, Wooden , Glass , Half Partition etc)
              <br/>
              Glass work
              <br/>
              Table
              <br/>
              Conference room
              <br/>
              Conference table
              <br/>
              Meeting Table
              <br/>
              Door & Window Work
              <br/>
              Wooden Rack
              <br/>
              Almira
              <br/>
              Drawer
              <br/>
              Pedestal drawer
              <br/>
              Polish Work
              <br/>
              Chair
              <br/>
              Modular kitchen
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('include/footer.php'); ?>

<script type="text/javascript" src="<?=site_url('assets/site/js/');?>jquery.fancybox.min.js"></script>

<script type="text/javascript">
  new WOW().init();
</script>

<script type="text/javascript">
  $(document).ready(function() {
  var bigimage = $("#big");
  var thumbs = $("#thumbs");
  //var totalslides = 10;
  var syncedSecondary = true;

  bigimage
    .owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    autoplay: true,
    dots: false,
    loop: true,
    autoHeight : true,
    responsiveRefreshRate: 200,
    navText: [
      '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
      '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
    ]
  })
    .on("changed.owl.carousel", syncPosition);

  thumbs
    .on("initialized.owl.carousel", function() {
    thumbs
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: 4,
    dots: true,
    nav: true,
    navText: [
      '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
      '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
    ],
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: 4,
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);

  function syncPosition(el) {
    //if loop is set to false, then you have to uncomment the next line
    //var current = el.item.index;

    //to disable loop, comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);/*el.item.count / 2 - 0.5);*/

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    //to this
    thumbs
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = thumbs.find(".owl-item.active").length - 1;
    var start = thumbs
    .find(".owl-item.active")
    .first()
    .index();
    var end = thumbs
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
      thumbs.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      thumbs.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      bigimage.data("owl.carousel").to(number, 100, true);
    }
  }

  thumbs.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    bigimage.data("owl.carousel").to(number, 300, true);
  });
});

</script>

<script type="text/javascript">
  $(document).ready(function() {
    // add all to same gallery
    $(".gallery a").attr("data-fancybox","mygallery");
    // assign captions and title from alt-attributes of images:
    $(".gallery a").each(function(){
      $(this).attr("data-caption", $(this).find("img").attr("alt"));
      $(this).attr("title", $(this).find("img").attr("alt"));
    });
    // start fancybox:
    $(".gallery a").fancybox();
  });
</script>