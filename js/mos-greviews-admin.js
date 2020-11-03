jQuery(document).ready(function($) {
    $(window).load(function(){
      $('.mos-greviews-wrapper .tab-con').hide();
      $('.mos-greviews-wrapper .tab-con.active').show();
    });

    $('.mos-greviews-wrapper .tab-nav > a').click(function(event) {
      event.preventDefault();
      var id = $(this).data('id');

      set_mos_greviews_cookie('plugin_active_tab',id,1);
      $('#mos-greviews-'+id).addClass('active').show();
      $('#mos-greviews-'+id).siblings('div').removeClass('active').hide();

      $(this).closest('.tab-nav').addClass('active');
      $(this).closest('.tab-nav').siblings().removeClass('active');
    });
});
