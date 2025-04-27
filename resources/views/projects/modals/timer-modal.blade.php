<!-- タイマーモーダル -->
<div class="modal fade" id="timerModal" tabindex="-1" aria-labelledby="timerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="timerModalLabel">作業タイマー</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>

        <div class="modal-body">

          <!-- ステップ1: 作業選択 -->
          <div id="step1">
            <form id="startTimerForm">
              <div class="mb-3">
                <label for="workTypeSelect" class="form-label">作業内容を選択してください</label>
                <select class="form-select" id="workTypeSelect" name="work_type_id" required>
                  <option value="" disabled selected>作業を選んでください</option>
                  @foreach ($all_work_types as $work_type)
                    <option value="{{ $work_type->id }}">{{ $work_type->name }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary w-100">タイマー開始</button>
            </form>
          </div>

          <!-- ステップ2: 作業中 -->
          <div id="step2" style="display: none;">
            <div class="text-center">
              <h5 id="workTypeText"></h5>
              <p class="fs-1" id="timerDisplay">00:00</p>
              <button id="stopTimerButton" class="btn btn-danger w-100">タイマー停止</button>
            </div>
          </div>

          <!-- ステップ3: 完了 & 保存フォーム -->
          <div id="step3" style="display: none;">
            <form method="POST" action="{{ route('WorkSession.store') }}">
              @csrf

              <input type="hidden" name="project_id" value="{{ $project->id }}">
              <input type="hidden" name="work_type_id" id="completedWorkTypeId">
              <input type="hidden" name="start_time" id="completedStartTime">
              <input type="hidden" name="end_time" id="completedEndTime">

              <div class="text-center">
                <h5 id="completedWorkTypeName"></h5>
                <p>作業時間：<span id="completedTime"></span>分</p>
                <p class="text-success" id="completedMessage"></p>

                <button type="submit" class="btn btn-success w-100 mt-3">保存して閉じる</button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    let startTime, timerInterval;

    document.getElementById('startTimerForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const workTypeSelect = document.getElementById('workTypeSelect');
      const selectedWorkTypeId = workTypeSelect.value;
      const selectedWorkTypeName = workTypeSelect.options[workTypeSelect.selectedIndex].text;

      if (!selectedWorkTypeId) return;

      // 作業内容を保持
      document.getElementById('workTypeText').textContent = selectedWorkTypeName;
      document.getElementById('completedWorkTypeId').value = selectedWorkTypeId;
      document.getElementById('completedWorkTypeName').textContent = `作業内容：${selectedWorkTypeName}`;

      // ステップを切り替え
      document.getElementById('step1').style.display = 'none';
      document.getElementById('step2').style.display = 'block';

      // 時間スタート
      startTime = new Date();
      document.getElementById('completedStartTime').value = startTime.toISOString(); // DB用にISO形式
      timerInterval = setInterval(updateTimerDisplay, 1000);
    });

    document.getElementById('stopTimerButton').addEventListener('click', function() {
      clearInterval(timerInterval);
      const endTime = new Date();
      const elapsedMinutes = Math.floor((endTime - startTime) / 60000);

      // 完了情報を設定
      document.getElementById('completedEndTime').value = endTime.toISOString(); // DB用にISO形式
      document.getElementById('completedTime').textContent = elapsedMinutes;

      // 作業内容（お疲れ様メッセージ）を設定
      const selectedWorkTypeName = document.getElementById('workTypeText').textContent;
      document.getElementById('completedWorkTypeName').textContent = `${selectedWorkTypeName}、お疲れ様でした！！！`;

      // ステップを切り替え
      document.getElementById('step2').style.display = 'none';
      document.getElementById('step3').style.display = 'block';
    });

    function updateTimerDisplay() {
      const now = new Date();
      const elapsed = now - startTime;
      const minutes = Math.floor(elapsed / 60000);
      const seconds = Math.floor((elapsed % 60000) / 1000);
      document.getElementById('timerDisplay').textContent =
        `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    // モーダルを閉じた時にリセット
    document.getElementById('timerModal').addEventListener('hidden.bs.modal', function () {
      clearInterval(timerInterval);
      document.getElementById('step1').style.display = 'block';
      document.getElementById('step2').style.display = 'none';
      document.getElementById('step3').style.display = 'none';
      document.getElementById('startTimerForm').reset();
      document.getElementById('timerDisplay').textContent = '00:00';
    });
  </script>

