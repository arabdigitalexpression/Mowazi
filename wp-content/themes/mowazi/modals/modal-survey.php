<button  style ="display:none;" type="button" class="survey-button btn btn-primary" data-toggle="modal" data-target="#surveyModal">
  Launch survey modal
</button>
<!-- Modal -->
<div class="modal fade come-from-modal right" id="surveyModal" tabindex="-1" role="dialog" aria-labelledby="survey modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h5>هل واجهتوا مشكلة في استخدام المنصة ؟</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="close-button btn btn-outline-secondary btn-sm" data-dismiss="modal">لا</button>
        <a href="https://forms.gle/btQG7wF2Yre3f5RN7" target="_blank" role="button" class="btn btn-primary">نعم</a>
      </div>
    </div>
  </div>
</div>

<!-- <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->

<script type="text/javascript">
// jQuery(document).ready(function(){
//     setTimeout(function(){
// 	jQuery('.survey-button').trigger('click')
// 	}, 60000)
// })

jQuery(document).ready(function(){
    setTimeout(function(){
    if (document.cookie.indexOf('modal_shown=') >= 0) {
      //do nothing if modal_shown cookie is present
      //alert('Your modal won\'t show again as it\'s shown before.');

      } else {
        jQuery('.survey-button').trigger('click')

        document.cookie = 'modal_shown=seen; max-age=31536000;'; //set cookie modal_shown
        //cookie will expire when browser is closed
      }
      },120000);
 });

</script>