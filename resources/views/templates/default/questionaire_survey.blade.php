@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
         <h2 class="title text-center">{{ trans('front.questionaire.survey') }}</h2>
         <!-- Center colunm-->
         <h4 style="font-weight: 600; font-size: 20px; text-align: center">{{ $questionaire['title'] }} </h4>
         <br><br>
         <div class="row">
            <div class="col-xs-12" id="question-content" style="padding: 0">

            </div>
         </div>
         <div style="margin-top: 7rem">
            <div class="col-xs-12 text-right">
               <button type="button" class="btn btn-info" id="btn-prev" onclick="prevQuestion()"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;Prev</button>
               <button type="button" class="btn btn-info" id="btn-next" onclick="nextQuestion()">Next&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
            </div>
         </div>
         <div style="margin-top: 15rem">
            <div class="col-xs-12 text-right">
               <button type="button" class="btn btn-success" style="display: none" id="btn-complete" onclick="completeQuestionaire()">Complete</button>
            </div>
         </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('triangle_picker/picker.js') }}"></script>
<link rel='stylesheet prefetch' href="{{ asset('triangle_picker/style.css') }}">
<script>
   let questions = @json($questionaire['questions']);
   let currQuestion;
   let answers = [];
   let currAnswerIdx = 0;
   $(document).ready(function() {
      if (questions.length < 1) {
         $("#btn-prev").prop('disabled', true);
         $("#btn-next").prop('disabled', true);
         $("#question-content").html('No questions.');
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
         let contentHtml = "Thank you for your answers. Please click \"Complete\" button to complete this questionnaire.";
         $("#question-content").html(contentHtml);
         $("#btn-next").prop("disabled", true);
         $("#btn-complete").show();
      } else {
         let contentHtml = '<div><p class="question">' + currQuestion.question.replace(/(\r\n|\n|\r)/gm, "<br>") + '</p></div>';
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
            contentHtml += '<div class="row"> <div class="col-xs-5">';
            contentHtml += '<div id="picker"></div>';
            contentHtml += '</div>';
            contentHtml += '<div class="col-xs-7 v-center"><div>';
            currQuestion.options.forEach(function(option, idx) {
               contentHtml += '<div style="margin: 10px 0;"><span style="border-bottom: 1px solid #eee;">';
               contentHtml += '<label style="font-weight: 400">' + option.option + ' &nbsp;:&nbsp;</label>';
               contentHtml += '<label id="label_triangle_' + idx + '">33</label>%';
               contentHtml += '</span></div>';
            });
            contentHtml += '</div></div></div>';
         } else if (currQuestion.answer_type == "input") {
            contentHtml += '<div style="display: flex; flex-direction: column; align-items: center">';
            contentHtml += '<div class="col-md-4" style="margin-bottom: 20px;">';
            contentHtml += '<label>' + "Email" + '</label>';
            contentHtml += '<input type="email" class="form-control email" name="email" value="">';
            contentHtml += '<p style="color: red" id="valid-email">' + "Please input a valid format email." + '</p>';
            contentHtml += '</div>';
            contentHtml += '</div>';
         }
         contentHtml += '</div>';
         $("#question-content").html(contentHtml);

         $("#question-content p#valid-email").hide();
         if (currQuestion.answer_type == "triangle") {
            initTrianglePicker();
         }
      }
   }

   function completeQuestionaire() {
      answers.splice(currAnswerIdx);
      $.ajax({
         type: "POST",
         data: {
            _token: "{{ csrf_token() }}",
            answers: answers,
            questionaire_id: {{ $questionaire['id'] }}
         },
         url: "{{ route('questionaire.add_answer') }}",
         success: function(response){
            if (response == 'ok') {
               alert("Thank you for your answers. Your answers are saved successfully");
               document.location.href = "{{ route('questionaire.index') }}";
            }
         }
      });
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
   }

   function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
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
         case "input":
            email = $("#question-content input.email").val();
            if (!isEmail(email)) {
               $("#question-content p#valid-email").show(); 
               return;           }
            if (typeof email === 'undefined' || email === null || email < 0) {
               return;
            }
            idx = 0;
            answerVal = email;
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
@endpush