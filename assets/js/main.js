// Main JS for GlamAura static site
document.addEventListener('DOMContentLoaded', function(){


  // Add/remove scrolled state to header for stronger shadow on scroll
  const header = document.querySelector('.site-header');
  const onScroll = ()=>{
    if(!header) return;
    if(window.pageYOffset > 12) header.classList.add('scrolled'); else header.classList.remove('scrolled');
  };
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  // Set copyright years
  const setYear = id => { const el = document.getElementById(id); if(el) el.textContent = new Date().getFullYear(); };
  setYear('year'); setYear('year-services'); setYear('year-about'); setYear('year-gallery'); setYear('year-testimonials'); setYear('year-contact');
  // Category / page specific years
  setYear('year-bridal'); setYear('year-makeup'); setYear('year-mehendi'); setYear('year-nail'); setYear('year-hairstyle');

  // Smooth scroll for internal links
  document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click', function(e){
      const href = this.getAttribute('href');
      if(href.length>1){
        e.preventDefault();
        document.querySelector(href)?.scrollIntoView({behavior:'smooth'});
      }
    });
  });

// Hero image slideshow (right side about section)
const slides = document.querySelectorAll(".slideshow .slide");

if(slides.length){
  let index = 0;

  setInterval(() => {
    slides[index].classList.remove("active"); 
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
  }, 3000);
}

  // Testimonial slider (simple)
  const testimonials = document.querySelectorAll('.testimonial-slider .testimonial');
  if(testimonials.length){
    let ti = 0;
    const show = i=>{
      testimonials.forEach((t,idx)=> t.classList.toggle('active', idx===i));
    };
    show(ti);
    setInterval(()=>{ ti = (ti+1)%testimonials.length; show(ti); }, 5000);
  }

  // Lightbox for gallery
  const lightbox = document.getElementById('lightbox');
  if(lightbox){
    const lbImg = lightbox.querySelector('img');
    document.querySelectorAll('.gallery-item').forEach(btn => {
      btn.addEventListener('click', ()=>{
        const src = btn.getAttribute('data-src');
        lbImg.src = src; lightbox.classList.add('show'); lightbox.setAttribute('aria-hidden','false');
      });
    });
    lightbox.querySelector('.lightbox-close').addEventListener('click', ()=>{
      lightbox.classList.remove('show'); lightbox.setAttribute('aria-hidden','true');
    });
    lightbox.addEventListener('click', (e)=>{ if(e.target===lightbox) { lightbox.classList.remove('show'); lightbox.setAttribute('aria-hidden','true'); }});
  }

  // Gallery category filters (show/hide categories without reload)
  const filterBtns = document.querySelectorAll('.category-filter-btn');
  if(filterBtns.length){
    const sections = document.querySelectorAll('.gallery-category');
    const setActive = (btn, shouldScroll=false)=>{
      filterBtns.forEach(b=>{ b.classList.toggle('active', b===btn); b.setAttribute('aria-pressed', b===btn); });
      const target = btn.getAttribute('data-target');
      sections.forEach(sec=>{
        if('#'+sec.id === target){ sec.classList.remove('hidden'); 
          if(shouldScroll) sec.scrollIntoView({behavior:'smooth',block:'start'});
        } else { sec.classList.add('hidden'); }
      });
    };
    filterBtns.forEach(btn=> btn.addEventListener('click', ()=> setActive(btn, true)));
    // initialize: show first and hide others (no scroll on page load)
    setTimeout(()=>{ const first = document.querySelector('.category-filter-btn.active') || filterBtns[0]; if(first) setActive(first, false); }, 80);
  }

  // Contact form handler (frontend-only)
  const form = document.getElementById('contactForm');
  if(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const result = document.getElementById('formResult');
      result.textContent = 'Sending...';
      // Simulate send
      setTimeout(()=>{
        result.textContent = 'Thanks! Your request was received. We will contact you within 24 hours.';
        form.reset();
      },900);
    });
  }

  // Service Detail Modal for category pages
  const detailModal = document.getElementById('serviceDetailModal');
  if(detailModal){
    const modalClose = detailModal.querySelector('.modal-close');
    const cardImages = document.querySelectorAll('.category-grid .card-image');
    
    // Open modal on card image click
    cardImages.forEach(card => {
      card.addEventListener('click', function(e){
        e.preventDefault();
        const parentCard = this.closest('.service-card');
        const img = this.querySelector('img');
        const title = parentCard.querySelector('.card-body h3').textContent;
        const price = parentCard.querySelector('.price').textContent;
        const duration = parentCard.getAttribute('data-duration') || '60 minutes';
        const description = parentCard.getAttribute('data-description') || 'Premium beauty service crafted with expert care and attention to detail.';
        
        // Populate modal
        document.getElementById('modalImage').src = img.src;
        document.getElementById('modalImage').alt = img.alt;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalPrice').textContent = price;
        document.getElementById('modalDuration').textContent = duration;
        document.getElementById('modalDescription').textContent = description;
        
        // Show modal
        detailModal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
      });
    });
    
    // Close modal
    const closeModal = () => {
      detailModal.classList.remove('show');
      document.body.style.overflow = '';
    };
    
    modalClose.addEventListener('click', closeModal);
    detailModal.addEventListener('click', (e)=>{
      if(e.target === detailModal) closeModal();
    });
    
    // Close on Escape key
    document.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape' && detailModal.classList.contains('show')) closeModal();
    });
    
    // Redirect to contact on "Book Now"
    const bookBtn = document.getElementById('modalBookBtn');
    if(bookBtn){
      bookBtn.addEventListener('click', ()=>{
        closeModal();
        window.location.href = 'contact.html';
      });
    }
  }
});
