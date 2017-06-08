/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../../node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//   el: 'body'
// });
$(function () {

  $('#btnGenToken').click(function () {
    var data = {
      name: 'Client Generate Token',
      scopes: []
    };

    $.post('/oauth/personal-access-tokens', data)
      .done(function (result) {
        $('#tokenWrapper').html(result.accessToken);
        $(this).attr('disabled', 'disabled');
      });
  })

  $('form').submit(function() {
    var mySubmitButtons = $(this).find('input[type="submit"], button[type="submit"]').not('.btn-download');
    mySubmitButtons.attr("disabled", true);
  });

});
