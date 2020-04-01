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
               <button type="button" class="btn btn-info" id="btn-prev" onclick="prevQuestion()"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;Prev</button>
               <button type="button" class="btn btn-info" id="btn-next" onclick="nextQuestion()">Next&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success" style="display: none" id="btn-complete" onclick="completeQuestionaire()">Complete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="{{ asset('triangle_picker/picker.js') }}"></script>
<link rel='stylesheet prefetch' href="{{ asset('triangle_picker/style.css') }}">
<script>
   let questions = @json($questionaire->questions);
   let currQuestion;
   let answers = [];
   let currAnswerIdx = 0;

   $(document).ready(function() {
      if (questions.length < 1) {
         return;
      }
      setTimeout(function() { showQuestionaire() }, 2000);
   });

   function showQuestionaire() {
      $('#questionaire-modal').modal({
         backdrop: 'static',
         keyboard: false
      });
      $("#btn-prev").prop("disabled", true);
      $("#btn-complete").hide();
      updateQuestionContent(questions[0].id);
   }

   function updateQuestionContent(questionId) {
      currQuestion = questions.find(element => element.id == questionId);
      if (!currQuestion) {
         let contentHtml = "Thank you for your answers. Please click \"Complete\" button to complete this questionaire.";
         $("#question-content").html(contentHtml);
         $("#btn-next").prop("disabled", true);
         $("#btn-complete").show();
      } else {
         let contentHtml = '<div><p class="question">' + currQuestion.question + '</p></div>';
         contentHtml += '<div class="answer-container">';
         let prevVal = answers[currAnswerIdx] ? answers[currAnswerIdx].answer : "";

         if (currQuestion.answer_type == "radio") {
            currQuestion.options.forEach(function(option, idx) {
               contentHtml += '<div class="radio"> <label>';
               contentHtml += '<input type="radio" class="answer-option" name="optradio" value="' + idx + '"' + (prevVal == option.option ? "checked" : "") + '>';
               contentHtml += option.option + '</label></div>';
            });
         } else if (currQuestion.answer_type == "select") {
            contentHtml += '<select class="form-control answer-option">';
            currQuestion.options.forEach(function(option, idx) {
               contentHtml += '<option value="' + idx + '"' + (prevVal == option.option ? " selected" : "") + '>' + option.option + '</option>';
            });
            contentHtml += '</select>';
         } else if (currQuestion.answer_type == "slider") {
            let prevIdx = 0;
            currQuestion.options.forEach(function(option, idx) {
               if (prevVal == option.option) {
                  prevIdx = idx;
               }
            });
            contentHtml += '<div class="range">';
            contentHtml += '<input type="range" min="0" max="' + (currQuestion.options.length-1) + '" value="' + prevIdx + '" class="slider answer-option">' ;
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
               contentHtml += '<label id="label_triangle_' + idx + '">33</label>%';
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
   }

   function completeQuestionaire() {
      answers.splice(currAnswerIdx);
      console.log(answers);
   }

   function prevQuestion() {
      if (currAnswerIdx < 0) {
         $("#btn-prev").prop("disabled", true);
         return;
      }

      $("#btn-next").prop("disabled", false);
      $("#btn-complete").hide();

      currAnswerIdx--;
      updateQuestionContent(answers[currAnswerIdx].question_id);

      if (currAnswerIdx == 0) {
         $("#btn-prev").prop("disabled", true);
      }

      console.log(answers);
   }

   function nextQuestion() {
      $("#btn-prev").prop("disabled", false);
      let answerVal = '';
      let idx;
      switch(currQuestion.answer_type) {
         case "radio":
            idx = $("#question-content input.answer-option:checked").val();
            if (typeof idx === 'undefined' || idx === null || idx < 0) {
               return;
            }
            answerVal = currQuestion.options[idx].option;
         break;
         case "select":
            idx = $("#question-content select.answer-option").val();
            if (typeof idx === 'undefined' || idx === null || idx < 0) {
               return;
            }
            answerVal = currQuestion.options[idx].option;
         break;
         case "slider":
            idx = $("#question-content input.answer-option").val();
            if (typeof idx === 'undefined' || idx === null || idx < 0) {
               return;
            }
            answerVal = currQuestion.options[idx].option;
         break;
         case "triangle":
            let vals = [
               Number.parseInt($("#question-content #triangle_0").val()),
               Number.parseInt($("#question-content #triangle_1").val()),
               Number.parseInt($("#question-content #triangle_2").val()),
            ];

            idx = vals.indexOf(Math.max(...vals));
            answerVal = JSON.stringify(vals);
         break;
      }

      // if current answer is set and different with current answer, ignore further answers
      if (answers[currAnswerIdx] && answers[currAnswerIdx].answer != answerVal) {
         answers.splice(currAnswerIdx+1);
      }

      answers[currAnswerIdx] = {question_id: currQuestion.id, answer: answerVal};
      currAnswerIdx++;

      updateQuestionContent(currQuestion.options[idx].next_question_id);
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
            color: 'rgb(255, 50, 50)',
            width: null,
            height: null,
            borderRadius: null
         },
         inputs: {
            topMiddle: {
               name: currQuestion.options[0].option,
               id: 'triangle_0',
               class: ''
            },
            bottomLeft: {
               name: currQuestion.options[1].option,
               id: 'triangle_1',
               class: ''
            },
            bottomRight: {
               name: currQuestion.options[2].option,
               id: 'triangle_2',
               class: ''
            },
            decimalPlaces: 0
         },
		};
      $("#picker").trianglePicker(defaults, function(name, values) {
         let idx = 1;
         for(k in values) {
            $("label#label_triangle_"+(idx%3)).text(values[k]);
            idx++;
         }
      });
   }

</script>
@endif