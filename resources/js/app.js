import './bootstrap';

import Chart from 'chart.js/auto';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

// For Calendar
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
                    const events = calendar.getEvents()
                        .filter(event => !event.extendedProps.synced) // 未同期のイベントだけ
                        .map(event => ({
                            id: event.id,
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

// For Data
// チャート用変数（破棄のため）
let jobChart, workChart, clientChart;

function renderPieChart(ctx, data, labelKey, valueKey) {
    const labels = data.map(d => d[labelKey]);
    const values = data.map(d => d[valueKey]);

    return new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: labels.map(() => `hsl(${Math.random() * 360}, 60%, 70%)`)
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: context => `${context.label}: ${context.parsed.toLocaleString()}`
                    }
                }
            }
        }
    });
}

document.getElementById('filterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = new FormData(this);
    const start = form.get('start');
    const end = form.get('end');

    const params = new URLSearchParams();
    if (start) params.append('start', start);
    if (end) params.append('end', end);

    // 数値データ取得
    const summaryRes = await fetch(`/api/summary?${params.toString()}`);
    const summary = await summaryRes.json();

    document.getElementById('projectCount').textContent = summary.project_count;
    document.getElementById('totalCharacters').textContent = summary.total_characters.toLocaleString();
    document.getElementById('totalSalary').textContent = summary.total_salary.toLocaleString();
    document.getElementById('totalMinutes').textContent = summary.total_minutes;
    document.getElementById('charactersPerHour').textContent = summary.characters_per_hour;
    document.getElementById('hourlyRate').textContent = summary.hourly_rate;

    // 円グラフデータ取得
    const chartRes = await fetch(`/api/charts?${params.toString()}`);
    const charts = await chartRes.json();

    // グラフ更新（破棄 → 再描画）
    if (jobChart) jobChart.destroy();
    if (workChart) workChart.destroy();
    if (clientChart) clientChart.destroy();

    jobChart = renderPieChart(
        document.getElementById('jobTypeChart').getContext('2d'),
        charts.job_types, 'label', 'count'
    );

    workChart = renderPieChart(
        document.getElementById('workTypeChart').getContext('2d'),
        charts.work_types, 'label', 'minutes'
    );

    clientChart = renderPieChart(
        document.getElementById('clientChart').getContext('2d'),
        charts.clients, 'label', 'count'
    );
});


