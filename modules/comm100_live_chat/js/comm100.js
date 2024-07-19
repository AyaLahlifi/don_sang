if(!drupalSettings.comm100.is_admin_page 
  && drupalSettings.comm100.site_id != '' 
  && drupalSettings.comm100.site_id != '0' 
  && drupalSettings.comm100.plan_id != '' 
  && drupalSettings.comm100.plan_id != '0'
  && drupalSettings.comm100.plan_type != '2') {

  // var Comm100API = Comm100API || new Object;
  // Comm100API.chat_buttons = Comm100API.chat_buttons || [];
  // var comm100_chatButton = new Object;
  // comm100_chatButton.code_plan = drupalSettings.comm100.plan_id;
  // comm100_chatButton.div_id = 'comm100-button-' + drupalSettings.comm100.plan_id;
  // Comm100API.chat_buttons.push(comm100_chatButton);
  // Comm100API.site_id = drupalSettings.comm100.site_id;
  // Comm100API.main_code_plan = drupalSettings.comm100.plan_id;

  // var comm100_lc = document.createElement('script');
  // comm100_lc.type = 'text/javascript';
  // comm100_lc.async = true;
  // comm100_lc.src = 'https://vue.comm100.com/livechat.ashx?siteId=' + Comm100API.site_id;
  // var comm100_s = document.getElementsByTagName('script')[0];
  // comm100_s.parentNode.insertBefore(comm100_lc, comm100_s);

  // setTimeout(function() {
  //     if (!Comm100API.loaded) {
  //       var lc = document.createElement('script');
  //       lc.type = 'text/javascript';
  //       lc.async = true;
  //       lc.src = 'https://vue.comm100.com/livechat.ashx?siteId=' + Comm100API.site_id;
  //       var s = document.getElementsByTagName('script')[0];
  //       s.parentNode.insertBefore(lc, s);
  //     }
  //   }, 5000)
  jQuery('<div id="comm100-button-' + drupalSettings.comm100.plan_id + '"></div>').insertAfter('body');
  var Comm100API=Comm100API||{};(function(t){function e(e){var a=document.createElement("script"),c=document.getElementsByTagName("script")[0];a.type="text/javascript",a.async=!0,a.src=e+t.site_id,c.parentNode.insertBefore(a,c)}t.chat_buttons=t.chat_buttons||[],t.chat_buttons.push({code_plan:drupalSettings.comm100.plan_id,div_id:"comm100-button-" + drupalSettings.comm100.plan_id}),t.site_id=drupalSettings.comm100.site_id,t.main_code_plan=drupalSettings.comm100.plan_id,e("https://vue.comm100.com/livechat.ashx?siteId="),setTimeout(function(){t.loaded||e("https://standby.comm100vue.com/livechat.ashx?siteId=")},5e3)})(Comm100API||{})
}
