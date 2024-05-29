document.addEventListener('DOMContentLoaded', function () {
  var animatedSection = document.getElementById('animatedSection');
  var windowHeight = window.innerHeight;

  function checkPosition() {
    var positionFromTop = animatedSection.getBoundingClientRect().top;

    if (positionFromTop - windowHeight <= 0) {
      animatedSection.classList.add('visible');
      window.removeEventListener('scroll', checkPosition);
    }
  }

  window.addEventListener('scroll', checkPosition);
  checkPosition();
});

document.addEventListener('DOMContentLoaded', function () {
  var heroElement = document.querySelector('.hero-elements');
  var windowHeight = window.innerHeight;
  var elementOffset = heroElement.getBoundingClientRect().top;

  if (elementOffset < windowHeight) {
    heroElement.style.opacity = '1';
    heroElement.style.transform = 'translateY(0)';
  } else {
    window.addEventListener('scroll', revealElement);
  }

  function revealElement() {
    var elementOffset = heroElement.getBoundingClientRect().top;

    if (elementOffset < windowHeight) {
      heroElement.style.opacity = '1';
      heroElement.style.transform = 'translateY(0)';
      window.removeEventListener('scroll', revealElement);
    }
  }
});

// about animasi
function isElementInViewport(el) {
  var rect = el.getBoundingClientRect();
  return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
}

function handleScroll() {
  var aboutImg = document.querySelector('.about-img');
  if (isElementInViewport(aboutImg)) {
    aboutImg.classList.add('active');
    window.removeEventListener('scroll', handleScroll);
  }
}

window.addEventListener('scroll', handleScroll);
