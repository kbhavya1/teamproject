<!DOCTYPE html>

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>project test</title>


    {!! Html::style('css/w3.css') !!}
    {!! Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') !!}
    {!! Html::style('css/mystyle.css') !!}

   <script
        src="https://code.jquery.com/jquery-1.8.0.min.js"
        integrity="sha256-jFdOCgY5bfpwZLi0YODkqNXQdIxKpm6y5O/fy0baSzE="
        crossorigin="anonymous">
   </script>

  <script>
            $.ajax({url: "{{url('ques')}}", success: function(result){
                var result=JSON.parse(result);

                Object.defineProperty(window, "questions", {
                      value: {
                        "physics":{
                          "Answered": 0,
                          "NAnswered": null,
                          "NVisited": null,
                          "markForReview": 0,
                          "totalCount":0,
                          "options":[],
                          "data":{}
                        },
                        "chemistry":{
                          "Answered": 0,
                          "NAnswered": null,
                          "NVisited": null,
                          "markForReview": 0,
                          "totalCount":0,
                            "options":[],
                          "data":{}
                        },
                        "maths":{                            //check
                          "Answered": 0,
                          "NAnswered": null,
                          "NVisited": null,
                          "markForReview": 0,
                          "totalCount":0,
                            "options":[],
                          "data":{}
                        },
                    },
                      writable: false
              });

                var createMap=function(subject,r){
                      var maxOptionsAllowed=6;// NEED TO PASS FROM CONTROLLER;
                        r.options={};
                        for(var opIdx=1;opIdx<=maxOptionsAllowed;opIdx++){
                            var currOp="op"+opIdx;
                          if(r[currOp]==null){
                            continue;
                          }
                          r.options[currOp]=r[currOp];
                          delete r[currOp];
                        }
                      r.status="NVistd";
                      r.selectedAnswed=null;
                      var nextIndex="rid"+(++questions[subject].totalCount);
                       questions[subject].data[nextIndex]=r;
                } ;

                result.forEach(function(r){
                      switch (r.subject) {
                        case "P":
                            createMap("physics",r);
                          break;
                          case "C":
                              createMap("chemistry",r);
                            break;
                            case "M":
                                createMap("maths",r);
                              break;
                      }


                });
              window.result=result;


              $(function(){
                  $("#includedContent").load("{{asset('template/script.tpl')}}");
                           $.getScript( "{{asset('js/main2.js')}}" )
                  .done(function( script, textStatus ) {
                      console.log( textStatus );


                  })
                  .fail(function( jqxhr, settings, exception ) {
                  $( "div.log" ).text( "Triggered ajaxError handler." );
              });
              });





                }});

    </script>

  {!! Html::script('js/underscore.js') !!}
    {!! Html::script('js/questions.js') !!}
  {!! Html::script('js/status.js') !!}




</head>

<body>
    
    <div class="header col-md-12">

        <div class="col-md-12 nav1"></div>
        <div class="col-md-12 nav2"></div>


    </div>
    <div class="main col-md-12">
        <div class="main-header col-md-12">
        <div class="col-md-10 no-padding">
        <div class="col-md-12">
                    <nav class="navbar navbar-default stylenv">
                        <div class="container-fluid"></div>
                        <div class="countdown">
                        <h4></h4>
                        </div>
                    </nav>
        </div>
            <!--this is a main div-->
        <div class="col-md-12">
            <nav class="navbar navbar-default stylenav">
                <div class="container-fluid">
                    <div class="tab col-md-12">
                        <button class="tablinks" id="subJect" onclick="Exam.setSubject('physics')">Physics</button>
                        <button class="tablinks" onclick="Exam.setSubject('chemistry')">Chemistry</button>
                        <button class="tablinks" onclick="Exam.setSubject('maths')">Maths</button>

                    </div>

                    <div id="London" class="tabcontent">
                        <h3>Physics</h3>
                        <p>This is the section for physics</p>
                    </div>

                    <div id="Chemistry" class="tabcontent">
                        <h3>Chemistry</h3>
                        <p>This is the section for chemistry.</p>
                    </div>

                    <div id="Tokyo" class="tabcontent">
                        <h3>Maths</h3>
                        <p>This is the section for maths</p>
                    </div>

                    <div class="navbar-header">
                    </div>


                </div>

            </nav>
        </div>
        </div>
            <!--This is photo div-->
         <div class="col-md-2">
             <!--<img src="img_avatar.png" alt="profile_pic" style="width:270px;height:138px;">-->
             {!! HTML::image('images/img_avatar.png', 'alt profile_pic', array('class' => 'profileimg')) !!}
         </div>
        </div>
        <div class="main-container col-md-12">
            <div class="col-md-10" id="start"></div>
            <div class="col-md-2"><!--<img src="shot2.png" alt="instruction" style="width:30vh;height:12vh"/>-->
              {!!HTML::image('images/shot2.png', 'alt instructions', array('class' => 'instructionimg')) !!}
            </div>
            <div class="col-md-2" id="subjectTrack">
            </div>
            </div>
    </div>

    <!--this is the bottom footer-->
    <div class="footer col-md-12">
        <div class="col-md-12">
                <nav class="navbar navbar-default botnav">
                <input type="button" value="Prev" class="tognext btn btn-default" onclick="Exam.getPrevQuestion()"/>
                <input type="button" value="Next" class="togprev btn btn-default" onclick="Exam.getNextQuestion()"/>
                <input type="button" value="Review" class="togprev btn btn-default" onclick="Exam.markQuestion()"/>
                <input type="button" value="Submit" class="togsubmit btn btn-primary" id="valSubmit" onclick="Exam.submitPaper()">
                </nav>
                <br>
                <br>
        </div>
    </div>


    <div id="includedContent">

    </div>

    <script>
      var timer2 = "180:00";
      var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  if (minutes < 0) clearInterval(interval);
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('h4').html('Time Left:'+minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
}, 1000);

    </script>
    {!! Form::open(array("id"=>"submitPaper",'url' => 'submitPaper', 'method' => 'POST') ) !!}
    {{ csrf_field() }}
    {!! Form::close() !!}
</body>

</html>
