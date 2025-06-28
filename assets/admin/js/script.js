(function() {
    'use strict';

    // Ukloni klasu 'active' sa sidebar i body prilikom učitavanja (sidebar otvoren)
    $('#sidebar').removeClass('active');
    $('#body').removeClass('active');

    // Toggle sidebar on Menu button click
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
       // $('#body').toggleClass('active');
    });
})();
