let btn = document.querySelector(".menu-icon");
let sidebar = document.querySelector(".sidebar");

btn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});



$(document).ready(function() {
  
  // Toggle sidebar and close all dropdowns when sidebar is closed
  $('.menu-icon').on('click', function() {
      $('.sidebar').toggleClass('close');
  });

  // Toggle individual dropdowns
  $('.my-icon-link').on('click', function() {
      if (!$('.sidebar').hasClass('close')) {
          $(this).next('.sub-menu').slideToggle();
      }
  });
});

$(document).ready(function() {
  const sidebar = $('.sidebar');
  const body = $('body');

  // Check local storage for sidebar state
  const sidebarState = localStorage.getItem("sidebarState");
  if (sidebarState === "expanded") {
      sidebar.removeClass("close").addClass("open");
      body.addClass("sidebar-expanded");
      
  } else {
      sidebar.removeClass("open").addClass("close");
      body.addClass("sidebar-collapsed");
  }
  

  // Toggle sidebar and save state
  $('#toggleSidebar').click(function() {
      sidebar.toggleClass("open close");
      body.toggleClass("sidebar-expanded sidebar-collapsed");
      
      // Save the state to local storage
      const isExpanded = sidebar.hasClass("open");
      localStorage.setItem("sidebarState", isExpanded ? "expanded" : "collapsed");
  });
});
