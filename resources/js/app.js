import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

let calendar; // グローバルにカレンダーインスタンスを保持

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('calendar');

    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            const calendarEl = document.getElementById('calendar-container');

            // 既存カレンダーがあれば破棄
            if (calendar) {
                calendar.destroy();
                calendar = null;
            }

            // FullCalendarの初期化
            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                selectable: true,//日付をマウスで選択できるかどうか
                // editable: true,//ドラッグ、リサイズできるかどうか
                events: '/api/projects', // イベント取得API

                eventClick: function(info) {
                    let projectId = info.event.id;
                    if (projectId) {
                        window.location.href = `/project/${projectId}/show`; // 先頭にスラッシュを追加
                    }
                    info.jsEvent.preventDefault();
                },

                // 日付をクリックした際の処理
                dateClick: function(info) {
                    let selectedDate = info.dateStr; // クリックされた日付（YYYY-MM-DD）
                    window.location.href = `/project/create?date=${selectedDate}`; // 作成ページにリダイレクト
                },
            });

            calendar.render();
        });
    }
});
