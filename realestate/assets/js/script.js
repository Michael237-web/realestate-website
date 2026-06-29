$(document).ready(function() {
    $('.mobile-toggle').on('click', function(e) {
        e.stopPropagation();
        $('.mobile-nav').toggleClass('active');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    $('.mobile-nav a').on('click', function() {
        $('.mobile-nav').removeClass('active');
        $('.mobile-toggle i').removeClass('fa-times').addClass('fa-bars');
    });
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.professional-header').length && !$(event.target).closest('.mobile-nav').length) {
            $('.mobile-nav').removeClass('active');
            $('.mobile-toggle i').removeClass('fa-times').addClass('fa-bars');
        }
    });
    $('.mobile-nav .dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('open');
        $(this).next('.mobile-sub-menu').slideToggle(300);
    });
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        if (target && target !== '#') {
            $('html, body').animate({
                scrollTop: $(target).offset().top - 80
            }, 800);
        }
    });
    $('.filter-select').change(function() {
        $(this).closest('form').submit();
    });
    $('.whatsapp-btn').click(function() {
        var phone = $(this).data('phone');
        var message = $(this).data('message');
        window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
    });
    $('.gallery-thumb').click(function() {
        var mainImage = $(this).data('full');
        $('#main-gallery-image').attr('src', mainImage);
        $('.gallery-thumb').removeClass('active');
        $(this).addClass('active');
    });
    $('#calculate-mortgage').click(function() {
        var price = parseFloat($('#property-price').val());
        var downPayment = parseFloat($('#down-payment').val()) || 0;
        var rate = parseFloat($('#interest-rate').val()) || 12;
        var years = parseInt($('#loan-years').val()) || 20;
        var loanAmount = price - downPayment;
        var monthlyRate = rate / 100 / 12;
        var months = years * 12;
        if (loanAmount > 0) {
            var monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
            $('#monthly-payment').text('KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        } else {
            $('#monthly-payment').text('KES 0');
        }
    });
    $('.newsletter-form').submit(function(e) {
        e.preventDefault();
        var email = $(this).find('input[type="email"]').val();
        if (email) {
            $.ajax({
                url: '../subscribe.php',
                method: 'POST',
                data: { email: email },
                success: function(response) {
                    alert('Thank you for subscribing!');
                    $('.newsletter-form input[type="email"]').val('');
                },
                error: function() {
                    alert('Thank you for subscribing!');
                    $('.newsletter-form input[type="email"]').val('');
                }
            });
        }
    });
    $('.favorite-btn').click(function() {
        var propertyId = $(this).data('id');
        var btn = $(this);
        $.ajax({
            url: '../wishlist.php',
            method: 'POST',
            data: { property_id: propertyId },
            success: function(response) {
                if (response === 'added') {
                    btn.addClass('active');
                    btn.find('i').removeClass('far').addClass('fas');
                } else if (response === 'removed') {
                    btn.removeClass('active');
                    btn.find('i').removeClass('fas').addClass('far');
                }
            }
        });
    });
});

var slideIndex = 0;
var slides = document.querySelectorAll('.hero-slide');
var dots = document.querySelectorAll('.hero-dot');
var slideInterval;

function showSlide(index) {
    if (!slides.length) return;
    slides.forEach(function(slide) {
        slide.classList.remove('active');
    });
    dots.forEach(function(dot) {
        dot.classList.remove('active');
    });
    if (index < 0) index = slides.length - 1;
    if (index >= slides.length) index = 0;
    slides[index].classList.add('active');
    if (dots[index]) dots[index].classList.add('active');
    slideIndex = index;
}

function changeSlide(direction) {
    if (!slides.length) return;
    var newIndex = slideIndex + direction;
    if (newIndex < 0) newIndex = slides.length - 1;
    if (newIndex >= slides.length) newIndex = 0;
    showSlide(newIndex);
    resetInterval();
}

function currentSlide(index) {
    showSlide(index);
    resetInterval();
}

function resetInterval() {
    clearInterval(slideInterval);
    if (slides.length > 0) {
        slideInterval = setInterval(function() {
            changeSlide(1);
        }, 5000);
    }
}

if (slides.length > 0) {
    showSlide(0);
    slideInterval = setInterval(function() {
        changeSlide(1);
    }, 5000);
}

$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('header.professional-header').addClass('scrolled');
        $('header.professional-header').css('box-shadow', '0 4px 30px rgba(0,0,0,0.12)');
    } else {
        $('header.professional-header').removeClass('scrolled');
        $('header.professional-header').css('box-shadow', '0 2px 20px rgba(0,0,0,0.06)');
    }
});

function showAdminToast() {
    var toast = document.getElementById('toastMessage');
    var content = document.getElementById('toastContent');
    if (toast && content) {
        content.innerHTML = '<i class="fas fa-shield-alt toast-icon"></i> <strong>Administrator Access Required</strong><br>Please login with your admin credentials. Only authorized personnel can list properties.';
        toast.className = 'toast-message warning show';
        setTimeout(function() {
            hideToast();
        }, 4000);
        setTimeout(function() {
            window.location.href = '../login.php';
        }, 1500);
    }
}

function hideToast() {
    var toast = document.getElementById('toastMessage');
    if (toast) {
        toast.className = 'toast-message';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toastMessage');
    if (toast && toast.classList.contains('show')) {
        setTimeout(function() {
            hideToast();
        }, 4000);
    }
});