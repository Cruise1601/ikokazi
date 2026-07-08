/**
 * Main Application JavaScript
 * IKO KAZI - Localized Job Marketplace
 */

// Check if user is authenticated
function isAuthenticated() {
  return document.body.dataset.authenticated === 'true';
}

// Get CSRF token from HTML
function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

// Format currency to KES
function formatCurrency(amount) {
  return new Intl.NumberFormat('en-KE', {
    style: 'currency',
    currency: 'KES'
  }).format(amount);
}

// Format date
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-KE', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}

// Show notification
function showNotification(message, type = 'info') {
  const notification = document.createElement('div');
  notification.className = `alert alert-${type}`;
  notification.textContent = message;
  
  const container = document.querySelector('.container');
  if (container) {
    container.insertBefore(notification, container.firstChild);
    
    setTimeout(() => {
      notification.remove();
    }, 5000);
  }
}

// Handle form submission
function handleFormSubmit(formId, endpoint) {
  const form = document.getElementById(formId);
  if (!form) return;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(form);
    formData.append('csrf_token', getCsrfToken());
    
    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        body: formData
      });
      
      const data = await response.json();
      
      if (data.success) {
        showNotification(data.message, 'success');
        if (data.redirect) {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1000);
        }
      } else {
        showNotification(data.message || 'An error occurred', 'error');
      }
    } catch (error) {
      console.error('Form submission error:', error);
      showNotification('An error occurred. Please try again.', 'error');
    }
  });
}

// Toggle mobile menu
function toggleMobileMenu() {
  const menu = document.querySelector('.mobile-menu');
  if (menu) {
    menu.classList.toggle('hidden');
  }
}

// Filter jobs
function filterJobs(filters) {
  const params = new URLSearchParams(filters);
  window.location.href = '/ikokazi/jobs?' + params.toString();
}

// Save job for later
async function saveJob(jobId) {
  if (!isAuthenticated()) {
    showNotification('Please log in to save jobs', 'warning');
    return;
  }
  
  try {
    const response = await fetch('/ikokazi/api/jobs/save.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': getCsrfToken()
      },
      body: JSON.stringify({ job_id: jobId })
    });
    
    const data = await response.json();
    if (data.success) {
      showNotification(data.message, 'success');
    } else {
      showNotification(data.message, 'error');
    }
  } catch (error) {
    console.error('Error saving job:', error);
    showNotification('Failed to save job', 'error');
  }
}

// Apply for job
async function applyForJob(jobId) {
  if (!isAuthenticated()) {
    window.location.href = '/ikokazi/login';
    return;
  }
  
  window.location.href = `/ikokazi/applications/apply?job_id=${jobId}`;
}

// Initialize tooltips
function initializeTooltips() {
  const tooltips = document.querySelectorAll('[data-tooltip]');
  tooltips.forEach(element => {
    element.addEventListener('mouseenter', function() {
      const tooltip = document.createElement('div');
      tooltip.className = 'tooltip';
      tooltip.textContent = this.dataset.tooltip;
      document.body.appendChild(tooltip);
      
      const rect = this.getBoundingClientRect();
      tooltip.style.top = (rect.top - 10) + 'px';
      tooltip.style.left = (rect.left + rect.width / 2) + 'px';
      
      setTimeout(() => tooltip.remove(), 3000);
    });
  });
}

// Document ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    initializeTooltips();
  });
} else {
  initializeTooltips();
}
