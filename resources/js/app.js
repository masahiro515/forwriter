import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

let calendar;

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('calendar');

    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            const calendarEl = document.getElementById('calendar-container');

            if (calendar) {
                calendar.destroy();
                calendar = null;
            }

            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                selectable: true,
                events: '/api/projects',

                eventClick: function(info) {
                    const projectId = info.event.id;
                    if (projectId) {
                        window.location.href = `/project/${projectId}/show`;
                    }
                    info.jsEvent.preventDefault();
                },

                dateClick: function(info) {
                    const selectedDate = info.dateStr;
                    window.location.href = `/project/create?date=${selectedDate}`;
                },
            });

            // Googleカレンダー同期ボタンの処理
            const syncBtn = document.getElementById('sync-google-calendar');
            if (syncBtn) {
                syncBtn.addEventListener('click', async function () {
                    const events = calendar.getEvents().map(event => ({
                        title: event.title,
                        start: event.start.toISOString(),
                        end: event.end ? event.end.toISOString() : null,
                    }));

                    try {
                        const response = await fetch('/api/sync-google-calendar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({ events }),
                            credentials: 'same-origin',
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('同期失敗レスポンス', errorText);
                            throw new Error('同期エラー');
                        }

                        const result = await response.json();
                        alert(result.message || '同期完了しました！');
                    } catch (error) {
                        console.error('同期中にエラーが発生しました', error);
                        alert('Googleカレンダーへの同期に失敗しました。');
                    }
                });
            }

            calendar.render();
        });
    }
});



