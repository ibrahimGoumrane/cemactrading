/**
 * CEMAC Trading - Main JavaScript File
 * Modern, performant, and accessible interactions
 */

document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  // Initialize components needed for single-page app
  initSmoothScrolling();
  initContactForm();
  initAnimations();
  initLanguageSwitcher();

  // Performance optimization
  initLazyLoading();
});

/**
 * Smooth Scrolling for Anchor Links
 */
function initSmoothScrolling() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      const targetElement = document.querySelector(targetId);

      if (targetElement) {
        e.preventDefault();

        // No header offset needed since we removed navigation
        const targetPosition = targetElement.offsetTop - 20;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });
      }
    });
  });
}

/**
 * Enhanced Contact Form
 */
function initContactForm() {
  const contactForm = document.getElementById("contact-form");
  if (!contactForm) return;

  // Real-time validation
  const inputs = contactForm.querySelectorAll("input, textarea");
  inputs.forEach((input) => {
    input.addEventListener("blur", function () {
      validateField(this);
    });

    input.addEventListener("input", function () {
      clearErrors(this);
    });
  });

  // Form submission
  contactForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (validateForm(this)) {
      submitForm(this);
    }
  });

  function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = "";

    // Remove existing errors
    clearErrors(field);

    // Validation rules
    switch (field.type) {
      case "email":
        if (value && !isValidEmail(value)) {
          isValid = false;
          errorMessage = getTranslation("invalid_email");
        }
        break;
    }

    if (field.hasAttribute("required") && !value) {
      isValid = false;
      errorMessage = getTranslation("field_required");
    }

    if (!isValid) {
      showFieldError(field, errorMessage);
    }

    return isValid;
  }

  function validateForm(form) {
    let isFormValid = true;
    const fields = form.querySelectorAll("[required]");

    fields.forEach((field) => {
      if (!validateField(field)) {
        isFormValid = false;
      }
    });

    return isFormValid;
  }

  function showFieldError(field, message) {
    field.classList.add("error");

    const errorElement = document.createElement("div");
    errorElement.className = "field-error";
    errorElement.textContent = message;
    errorElement.setAttribute("role", "alert");

    field.parentNode.appendChild(errorElement);
  }

  function clearErrors(field) {
    field.classList.remove("error");
    const errorElement = field.parentNode.querySelector(".field-error");
    if (errorElement) {
      errorElement.remove();
    }
  }

  async function submitForm(form) {
    const submitButton = form.querySelector(".btn-submit");
    const originalText = submitButton.innerHTML;

    // Show loading state
    submitButton.innerHTML =
      '<i class="fas fa-spinner fa-spin"></i> Sending...';
    submitButton.disabled = true;

    try {
      const formData = new FormData(form);

      const response = await fetch(`${BASE_PATH}api/contact`, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        form.reset();
      }
    } catch (error) {
      console.error("Form submission error:", error);
    } finally {
      submitButton.innerHTML = originalText;
      submitButton.disabled = false;
    }
  }
}

/**
 * Scroll Animations
 */
function initAnimations() {
  // Intersection Observer for scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
      }
    });
  }, observerOptions);

  // Observe elements for animation
  const animateElements = document.querySelectorAll(
    ".service-card, .why-item, .product-card-mobile"
  );
  animateElements.forEach((element) => {
    observer.observe(element);
  });
}

/**
 * Language Switcher for Floating Menu
 */
function initLanguageSwitcher() {
  const languageSwitcher = document.getElementById("language-switcher");
  const languageToggle = document.getElementById("language-toggle");
  const languageDropdown = document.getElementById("language-dropdown");

  if (!languageSwitcher || !languageToggle || !languageDropdown) return;

  // Toggle dropdown on click
  languageToggle.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    languageSwitcher.classList.toggle("active");
  });

  // Close dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (!languageSwitcher.contains(e.target)) {
      languageSwitcher.classList.remove("active");
    }
  });

  // Close dropdown on escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      languageSwitcher.classList.remove("active");
    }
  });

  // Handle language selection
  const languageOptions = languageDropdown.querySelectorAll(".language-option");
  languageOptions.forEach((option) => {
    option.addEventListener("click", function (e) {
      // Show loading state
      const loadingSpinner = showLoadingSpinner();
      document.body.appendChild(loadingSpinner);

      // Small delay to show loading state
      setTimeout(() => {
        window.location.href = this.href;
      }, 150);
    });
  });
}

/**
 * Lazy Loading for Images
 */
function initLazyLoading() {
  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src || img.src;
          img.classList.remove("loading");
          imageObserver.unobserve(img);
        }
      });
    });

    document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
      img.classList.add("loading");
      imageObserver.observe(img);
    });
  }
}

/**
 * Preload Critical Assets
 /**
 * Utility Functions
 */
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function getCurrentLanguage() {
  const path = window.location.pathname;
  const langMatch = path.match(/^\/([a-z]{2})\//);
  return langMatch ? langMatch[1] : "en";
}

function getTranslation(key) {
  // Simple translation helper - in a real app, this would fetch from a translation object
  const translations = {
    en: {
      invalid_email: "Please enter a valid email address",
      field_required: "This field is required",
      contact_error:
        "An error occurred while sending your message. Please try again.",
    },
    fr: {
      invalid_email: "Veuillez entrer une adresse email valide",
      field_required: "Ce champ est obligatoire",
      contact_error:
        "Une erreur s'est produite lors de l'envoi de votre message. Veuillez réessayer.",
    },
    ar: {
      invalid_email: "يرجى إدخال عنوان بريد إلكتروني صحيح",
      field_required: "هذا الحقل مطلوب",
      contact_error: "حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى.",
    },
  };

  const currentLang = getCurrentLanguage();
  return translations[currentLang]?.[key] || translations["en"]?.[key] || key;
}

function showAlert(type, message) {
  const alertContainer = document.createElement("div");
  alertContainer.className = `alert alert-${type}`;
  alertContainer.innerHTML = `
        <i class="fas fa-${
          type === "success" ? "check-circle" : "exclamation-circle"
        }"></i>
        ${message}
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

  // Insert alert at the top of the main content
  const mainContent = document.querySelector(".main-content") || document.body;
  mainContent.insertBefore(alertContainer, mainContent.firstChild);

  // Auto-remove after 5 seconds
  setTimeout(() => {
    if (alertContainer.parentNode) {
      alertContainer.remove();
    }
  }, 5000);

  // Scroll to alert
  alertContainer.scrollIntoView({ behavior: "smooth", block: "nearest" });
}

/**
 * Create and show loading spinner
 */
function showLoadingSpinner() {
  const spinner = document.createElement("div");
  spinner.className = "loading-spinner";
  spinner.innerHTML = '<div class="spinner"></div><p>Changing language...</p>';
  spinner.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    gap: 1rem;
    font-size: 1.1rem;
    color: var(--primary-color);
  `;
  return spinner;
}

// CSS for field errors and loading states
const style = document.createElement("style");
style.textContent = `
    .form-group input.error,
    .form-group textarea.error {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }
    
    .field-error {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .field-error::before {
        content: "⚠";
    }
    
    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 50%;
        transition: background-color 0.2s;
    }
    
    .alert-close:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    img.loading {
        filter: blur(2px);
        transition: filter 0.3s;
    }
    
    .skip-link:focus {
        top: 6px !important;
    }

    .service-card,
    .why-item,
    .product-card-mobile {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }

    .service-card.animate,
    .why-item.animate,
    .product-card-mobile.animate {
        opacity: 1;
        transform: translateY(0);
    }
    
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;

document.head.appendChild(style);

// Performance monitoring (optional)
if ("performance" in window) {
  window.addEventListener("load", function () {
    setTimeout(() => {
      const perfData = performance.getEntriesByType("navigation")[0];
      console.log(
        `Page load time: ${perfData.loadEventEnd - perfData.fetchStart}ms`
      );
    }, 0);
  });
}

// Error handling
window.addEventListener("error", function (e) {
  console.error("JavaScript Error:", e.error);
  // In production, you might want to send this to an error tracking service
});

// Service Worker registration (for PWA features)
if ("serviceWorker" in navigator && location.protocol === "https:") {
  navigator.serviceWorker.register("/sw.js").catch(console.error);
}
