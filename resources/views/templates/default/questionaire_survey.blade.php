@if(isset($questionaire))
<!-- Modal -->
<div class="modal" id="questionaire-modal">
  <div class="modal-dialog modal-lg">
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
<script src="{{ asset('triangle_picker/picker.js') }}"></script>
<link rel='stylesheet prefetch' href="{{ asset('triangle_picker/style.css') }}">
<script>
   let questions = @json($questionaire->questions);
   let currQuestion;
   
   $(document).ready(function() {
      setTimeout(function() { showQuestionaire() }, 2000);
   });

   function showQuestionaire() {
      $('#questionaire-modal').modal({
         backdrop: 'static',
         keyboard: false
      });
      updateQuestionContent(questions[0].id);
   }

   function updateQuestionContent(questionId) {
      currQuestion = questions.find(element => element.id == questionId);
      let contentHtml = '<div><p class="question">' + currQuestion.question + '</p></div>';
      contentHtml += '<div class="answer-container">';
      if (currQuestion.answer_type == "radio") {
         currQuestion.options.forEach(function(option) {
            contentHtml += '<div class="radio"> <label> <input type="radio" name="optradio" value="' + option.id + '">' + option.option + '</label></div>';
         });
      } else if (currQuestion.answer_type == "select") {
         contentHtml += '<select class="form-control">';
         currQuestion.options.forEach(function(option) {
            contentHtml += '<option value="' + option.id + '">' + option.option + '</option>';
         });
         contentHtml += '</select>'
      } else if (currQuestion.answer_type == "slider") {
         contentHtml += '<div class="range">';
         contentHtml += '<input type="range" min="1" max="' + currQuestion.options.length + '" value="1" class="slider">' ;
         contentHtml += '<div class="sliderticks">';
         currQuestion.options.forEach(function(option) {
            contentHtml += '<p>' + option.option + '</p>';
         });
         contentHtml += '</div></div>';
      } else if (currQuestion.answer_type == "triangle") {
         contentHtml += '<div class="row"> <div class="col-xs-9">';
         contentHtml += '<div id="picker"></div>';
         contentHtml += '</div>';
         contentHtml += '<div class="col-xs-3 v-center"><div>';
         currQuestion.options.forEach(function(option, idx) {
            contentHtml += '<div style="margin: 10px 0;"><span style="border-bottom: 1px solid #eee;">';
            contentHtml += '<label style="font-weight: 400">' + option.option + ' &nbsp;:&nbsp;</label>';
            contentHtml += '<label id="triangle_' + option.option + '">33</label>%';
            contentHtml += '</span></div>';
         });
         contentHtml += '</div></div></div>';
      }
      contentHtml += '</div>';
      $("#question-content").html(contentHtml);

      if (currQuestion.answer_type == "triangle") {
         initTrianglePicker();
      }
   }

   function initTrianglePicker() {
      var defaults = {
         polygon: {
            width: null,
            fillColor: '#234567',
            line: { 
               width: 2,
               color: '#234567',
               centerLines: true,
               centerLineWidth: null
            }
         },
         handle: {
            color: '#CCDDFF',
            width: null,
            height: null,
            borderRadius: null
         },
         inputs: {
            topMiddle: {
               name: currQuestion.options[0].option,
               id: 'triangle_t',
               class: ''
            },
            bottomLeft: {
               name: currQuestion.options[1].option,
               id: 'triangle_bl',
               class: ''
            },
            bottomRight: {
               name: currQuestion.options[2].option,
               id: 'triangle_br',
               class: ''
            },
            decimalPlaces: 0
         },
		};
      $("#picker").trianglePicker(defaults, function(name, values) {
         let idx = 0;
         for(k in values) {
            let showK = values[k];
            showK = Math.max(1, Math.min(showK, 99));
            $("label#triangle_"+k).text(showK);
            idx++;
         }
      });
   }
</script>
@endif