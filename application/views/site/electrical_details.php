<?php include_once('include/header.php'); ?>

<link rel="stylesheet" type="text/css" href="<?=site_url('assets/site/css/');?>jquery.fancybox.min.css">

<div class="innerer_banner">
  <div class="container">
    <div class="box_us16">
      <h1>Electrical Services</h1>
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
                  <a href="<?=site_url('assets/site/img/');?>details/electrical/electrical_1.jpg"><img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_1.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/electrical/electrical_2.jpg"><img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_2.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/electrical/electrical_3.jpg"><img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_3.jpg"></a>
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <a href="<?=site_url('assets/site/img/');?>details/electrical/electrical_4.jpg"><img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_4.jpg"></a>
                </div>
              </div>
            </div>
            <div id="thumbs" class="owl-carousel owl-theme">
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_1.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_2.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_3.jpg">
                </div>
              </div>
              <div class="item">
                <div class="igm_owl">
                  <img src="<?=site_url('assets/site/img/');?>details/electrical/electrical_4.jpg">
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>

          <div class="box_us15">
            <h3 class="details-heading">Commercial Services</h3>
            <hr>
            <ul>
              <li>Project Planning</li>
              <li>Wiring</li>
              <li>Site Inspections</li>
              <li>Electrical Product Installation</li>
              <li>Service Work - Troubleshooting</li>
              <li>Underground Cabelling</li>
              <li>Maintenance</li>
              <li>Remodeling - Retrofits</li>
            </ul>
            <h3 class="details-heading">Domestic Services</h3>
            <hr>
            <ul>
              <li>Project Planning</li>
              <li>Wiring</li>
              <li>Site Inspections</li>
              <li>Wiring</li>
              <li>Electric Service Upgrades</li>
              <li>New Panels and Breakers</li>
              <li>Outdoor Lighting</li>
            </ul>
            <h3 class="details-heading">Premium Services</h3>
            <hr>
            <ul>
              <li>Swimming Pool Wiring</li>
              <li>Smart Home Wiring</li>
              <li>Security Lighting</li>
            </ul>
            <p>
              <strong>We are flexible with our contracts, we provide ability to our customers to choose either 'With Material' or 'Without Material' option.</strong>
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