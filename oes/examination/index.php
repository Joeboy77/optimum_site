<?php
include('includes/header.php');
?>

    <!-- Beginning of exams body -->
    <section class=" pt-2">
      <div class="container-fluid ">
        <!-- <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-table me-2"></i> Edit Daily Debtors Information</span>
        </div> -->
            <div class="card">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                 <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Details</h5>
              </div>
              <div class="row card-body d-flex">
                  <div class="row">
                    <div class="col-lg-2 col-lg-push-10">
                      <div id="current_que" style="float: left;">0</div>
                      <div style="float: left;">/</div>
                      <div id="total_que" style="float: left;">0</div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                      <div class="row">
                        <div class="col-lg-10 col-lg-push-1" style="min-height: 300px; background-color: white;" id="load_questions">
                          
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <div class="col-lg-6 col-lg-push-3" style="min-height: 50px;">
                          <div class="col-lg-12 text-center">
                            <input type="button" class="btn btn-warning" value="previous" onclick="load_previous();">&nbsp;
                            <input type="button" class="btn btn-success" value="next" onclick="load_next();">
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
      </div>
    </section>
    <!-- End of exams body -->

    <script type="text/javascript">
      function load_total_que(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("total_que").innerHTML=xmlhttp.responseText;
          }
        };
        xmlhttp.open("GET", "forajax/load_total_que.php", true)
        xmlhttp.send(null);
      }

      var questionno="1";
      load_questions(questionno);
      function load_questions(questionno){
        document.getElementById("current_que").innerHTML=questionno;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            if (xmlhttp.responseText=="over") {
              window.location="result.php"
            }else{
              document.getElementById("load_questions").innerHTML=xmlhttp.responseText;
              load_total_que();
            }
          }
        };
        xmlhttp.open("GET", "forajax/load_questions.php?questionno="+ questionno, true)
        xmlhttp.send(null);
      }

      function load_previous(){
        if (questionno=="1") {
          load_questions(questionno);
        }else{
          questionno=eval(questionno)-1;
          load_questions(questionno);
        }
      }

      function load_next{
        questionno=eval(questionno)+1;
        load_questions(questionno);
      }
    </script>

    <!-- <div class="container d-flex justify-content-center align-items-center min-vh-100"></div> -->
<?php
include('includes/footer.php');
?>
    




