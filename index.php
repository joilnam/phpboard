<!doctype html>
<html lang="ko">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <title>Crud Jquery</title>
</head>
<body>
  <div class="container mt-5 mb-5">
    <div class="row">
      <div class="col-6">
        <h1>데이터 테이블</h1>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-primary float-right" onclick="form_add()">추가하기</button>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">번호</th>
                <th scope="col">이름</th>
                <th scope="col">주소</th>
                <th scope="col">전공</th>
                <th scope="col">동작</th>
              </tr>
            </thead>
            <tbody>
              <!-- List Data Menggunakan DataTable -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- START Modal Form -->
  <div class="modal fade" id="modalmhs" tabindex="-1" role="dialog" aria-labelledby="modalmhs" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form onsubmit="return save_data()">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">회원등록</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">이름</label>
                <input type="text" class="form-control" name="name" id="name">
              </div>
              <div class="form-group col-md-6">
                <label for="major">전공</label>
                <select name="major" id="major" class="form-control">
                  <option value="infomation">정보관리자</option>
                  <option value="history">역사가</option>
                  <option value="movie">영화감독</option>
                  <option value="manager">매니저</option>
                  <option value="artist">예술가</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="adress">주소</label>
                <textarea class="form-control" rows="5" name="adress" id="adress"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="mr-auto">
              <button type="submit" class="btn btn-primary">등록</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- END Modal Form -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    //Tempat Proses Jquery Ajax
    var save_method, table, message;
    //Menerapkan plugin datatables
    $(function() {
      table = $('.table').DataTable({
        "processing": true,
        "ajax": "ajax/ajax_table.php?action=table_data"
      });
    });
    function form_add() {
      save_method = "add";
      $('#modalmhs').modal('show');
      $('#modalmhs form')[0].reset();
      $('.modal-title').text('등록 입력');
    }

    function form_edit(id) {
      save_method = "edit";
      $.ajax({
        url: "ajax/ajax_table.php?action=form_data&id=" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#modalmhs').modal('show');
          $('.modal-title').text('수정사항 입력');

          $('#id').val(data.id);
          $('#name').val(data.name);
          $('#adress').val(data.adress);
          $('#major').val(data.major);
        },
        error: function() {
          alert("내용 확인하세요!");
        }
      });
    }

    function save_data() {
      if (save_method == "add") {
        url = "ajax/ajax_table.php?action=insert";
        message = "등록성공";
      } else {
        url = "ajax/ajax_table.php?action=update";
        message = "등록실패";
      }

      $.ajax({
        url: url,
        type: "POST",
        data: $('#modalmhs form').serialize(),
        success: function() {
          $('#modalmhs').modal('hide');
          $('#modalmhs form')[0].reset();
          alert(message);
          table.ajax.reload();
        },
        error: function() {
          alert("수정사항 다시 확인 바랍니다!");
        }
      });
      return false;
    }

    function delete_data(id) {
      if (confirm("정말로 삭제하시겠습니까?")) {
        $.ajax({
          url: "ajax/ajax_table.php?action=delete&id=" + id,
          type: "GET",
          success: function(data) {
            alert("데이터 삭제가 완료되었습니다")
            table.ajax.reload();
          },
          error: function() {
            alert("처리 불가 확인해주세요!");
          }
        });
      }
    }
  </script>
</body>
</html>