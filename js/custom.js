/*tabel*/

  $('#extent_tbl1, .mytabvle').DataTable();

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

        $('.nav_top a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')

        $('.nav_top a').click(function(){

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


/*hover*/

// - Noel Delgado | @pixelia_me

const nodes = [].slice.call(document.querySelectorAll('li'), 0);
const directions  = { 0: 'top', 1: 'right', 2: 'bottom', 3: 'left' };
const classNames = ['in', 'out'].map((p) => Object.values(directions).map((d) => `${p}-${d}`)).reduce((a, b) => a.concat(b));

const getDirectionKey = (ev, node) => {
  const { width, height, top, left } = node.getBoundingClientRect();
  const l = ev.pageX - (left + window.pageXOffset);
  const t = ev.pageY - (top + window.pageYOffset);
  const x = (l - (width/2) * (width > height ? (height/width) : 1));
  const y = (t - (height/2) * (height > width ? (width/height) : 1));
  return Math.round(Math.atan2(y, x) / 1.57079633 + 5) % 4;
}

class Item {
  constructor(element) {
    this.element = element;    
    this.element.addEventListener('mouseover', (ev) => this.update(ev, 'in'));
    this.element.addEventListener('mouseout', (ev) => this.update(ev, 'out'));
  }
  
  update(ev, prefix) {
    this.element.classList.remove(...classNames);
    this.element.classList.add(`${prefix}-${directions[getDirectionKey(ev, this.element)]}`);
  }
}

nodes.forEach(node => new Item(node));
/*hover*/