<div id="edit-event-module" class="hidden">
    <link rel="stylesheet" type="text/css" href="/edit-event-module/edit-event-ui.css?v=1.000" />

    <div class="editting-window">
    	<h1 class="typography-header">이벤트 수정</h1>
    	<input class="event-id" type="hidden" name="event_id" />
    	<input class="date-input out-at" type="text" name="out_at" placeholder="시작일" />
    	<input class="date-input in-at" type="text" name="in_at" placeholder="종료일" />
    	<select class="type" name="type" required>
    		<option selected disabled hidden value="0">분류</option>
    		<?php
    		$sql = "SELECT * FROM event_name ORDER BY sequence";
    		$result = mysqli_query($conn, $sql);
    		if (!$result) echo mysqli_error($conn);
    		while ($row = mysqli_fetch_assoc($result)) {
    		?>
    		<option value="<?php echo $row['id']; ?>"><?php echo $row['event']; ?></option>
    		<?php
    		}
    		?>
    	</select>
    	<input class="display-name" type="text" name="display_name" placeholder="표시명(병원 사유)" />
        <input type="text" class="time-input out-time" name="out_time" value="" placeholder="시작 시간">
        <input type="text" class="time-input in-time" name="in_time" value="" placeholder="종료 시간">
        <input type="text" class="time-input note" name="note" value="" placeholder="비고(병원명)">
    	<div class="edit-window-button-container">
    		<button class="save-changes">저장</button>
    		<button class="discard-changes">취소</button>
    	</div>
    </div>

    <div class="editting-background">

    </div>

    <script src="/edit-event-module/edit-event.js?v=1.000"></script>
</div>
