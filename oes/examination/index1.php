
    <!-- Beginning of exams body -->
    <section class=" pt-3 vh-100">
      <div class="container-fluid ">
        <!-- <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-table me-2"></i> Edit Daily Debtors Information</span>
        </div> -->
        <div class="row ">
            <div class="card shadow h-100 py-2">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                 <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Details</h5>
              </div>
              <div class="row card-body d-flex">
                  <div class="row">
                    <div id="current_que" style="float: left;">0</div>
                    <div style="float: left;">/</div>
                    <div id="total_que" style="float: left;">0</div>

                    <div class="row" style="margin-top: 30px;">
                      <div class="row">
                        <div class="col-lg-10 col-lg-push-1" style="min-height: 300px; background-color: white;" id="load_question">
                          
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
      </div>
    </section>
    <!-- End of exams body -->

    <script type="text/javascript">
      function load_total_que(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("total_que").innerHTML=xmlhttp.responseText;
          }
        };
        xmlhttp.open("GET", "forajax/load_total_que.php", true)
        xmlhttp.send(null);
      }

      var questionno = "1";
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


<!-- Logout Modal -->
  <div class="modal fade" id="logoutModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="text-center">Select "<span style="color: red;">Logout</span>" below to end your current session.</div>
        <div class="modal-footer">
          <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
          <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>
