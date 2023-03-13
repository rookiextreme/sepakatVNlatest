<script>
  let currentRotate = 0;
  let defaultDegree = 90;
  let degree = 0;

  const rotateLeft = function(self){
    defaultDegree = parseInt(document.getElementById('defaultDegree').value);
    degree = degree - defaultDegree;
    omitMe();
  }

  const rotateRight = function(self){
    defaultDegree = parseInt(document.getElementById('defaultDegree').value);
    degree = degree + defaultDegree;
    omitMe();
  }

  const omitMe = function(){
    $('#enlarge_img').css({
      'transform': 'rotate('+degree+'deg)'
    });
  }
</script>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" aria-labelledby="enlargeImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <select name="" class="form-select" id="defaultDegree">
              <option value="45">45 Darjah</option>
              <option value="90" selected>90 Darjah</option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="btn-group">
              <button type="button" class="btn cux-btn bigger" onclick="rotateLeft(this)"> <i class="fa fa-undo-alt"></i> Putar Ke Kiri</button>
              <button type="button" class="btn cux-btn bigger" onclick="rotateRight(this)"> Putar Ke Kanan <i class="fa fa-redo-alt"></i> </button>
            </div>
          </div>
        </div>
        <h5 class="modal-title mt-3 mb-3 text-dark" id="exampleModalLabel"></h5>
        <div class="text-center d-grid justify-content-center" style="overflow: auto; height: 500px">
          <img id="enlarge_img" class="" src="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
