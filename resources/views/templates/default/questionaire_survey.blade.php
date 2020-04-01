@if(isset($questionaire))
<!-- Modal -->
<div class="modal fade" id="questionaire-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title" id="myModalLabel">{{ $questionaire->title }}</h4>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-xs-12" id="question-content">

            </div>
         </div>
         <div class="row" style="margin-top: 2rem">
            <div class="col-xs-12 text-center">
               <button type="button" class="btn btn-info"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;Prev</button>
               <button type="button" class="btn btn-info">Next&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success">Complete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
   let questions = @json($questionaire->questions);
   $(document).ready(function() {
      $('#questionaire-modal').modal({
         backdrop: 'static',
         keyboard: false
      });
      updateQuestionContent(questions[0].id);
   });

   function updateQuestionContent(questionId) {
      let question = questions.find(element => element.id == questionId);
      let contentHtml = '<div><p class="question">' + question.question + '</p></div>';
      contentHtml += '<div class="answer-container">';
      if (question.answer_type == "radio") {
         question.options.forEach(function(option) {
            contentHtml += '<div class="radio"> <label> <input type="radio" name="optradio" value="' + option.id + '">' + option.option + '</label></div>';
         });
      } else if (question.answer_type == "select") {
         contentHtml += '<select class="form-control">';
         question.options.forEach(function(option) {
            contentHtml += '<option value="' + option.id + '">' + option.option + '</option>';
         });
         contentHtml += '</select>'
      } else if (question.answer_type == "slider") {
         contentHtml += '<div class="range">';
         contentHtml += '<input type="range" min="1" max="' + question.options.length + '" value="1" class="slider">' ;
         contentHtml += '<div class="sliderticks">';
         question.options.forEach(function(option) {
            contentHtml += '<p>' + option.option + '</p>';
         });
         contentHtml += '</div></div>';
      }
      contentHtml += '</div>';
      $("#question-content").html(contentHtml);
   }
</script>
@endif