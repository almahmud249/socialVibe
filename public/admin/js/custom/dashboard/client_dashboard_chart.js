(function ($) {
    "use strict";

    const today_scheduled_post_charts_data = JSON.parse(document.getElementById('today_scheduled_post_charts_data').value);
    const scheduled_post_charts_data = JSON.parse(document.getElementById('scheduled_post_charts_data').value);
    const post_statistic_charts_data = JSON.parse(document.getElementById('post_statistic_charts_data').value);

    $(document).ready(function () {
        var statisticsItem = $("#post_statistic")[0];

        if (statisticsItem) {
            var data = {
                labels: post_statistic_charts_data.labels,
                datasets: [{
                    label: 'Facebook',
                    backgroundColor: 'rgba(28, 155, 244, 0.8)',
                    data: post_statistic_charts_data.facebook
                }, {
                    label: 'Instagram',
                    backgroundColor: 'rgba(255, 79, 145, 0.8)',
                    data: post_statistic_charts_data.instagram
                }, {
                    label: 'Linkedin',
                    backgroundColor: 'rgba(28, 141, 217, 0.8)',
                    data: post_statistic_charts_data.linkedin
                }, {
                    label: 'X/Twitter',
                    backgroundColor: 'rgba(0, 0, 0, 0.5)',
                    data: post_statistic_charts_data.x
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };
            new Chart(statisticsItem, {
                type: 'line',
                data: data,
                options: options
            });
        }

        var scheduledStatisticsItem = $("#scheduled_post_statistic")[0];

        if (scheduledStatisticsItem) {
            var data = {
                labels: scheduled_post_charts_data.labels,
                datasets: [{
                    label: 'X/Twitter',
                    backgroundColor: 'rgba(0,0,0,0.5)',
                    data: scheduled_post_charts_data.x
                }, {
                    label: 'Facebook',
                    backgroundColor: 'rgba(28, 155, 244, 0.5)',
                    data: scheduled_post_charts_data.facebook
                }, {
                    label: 'Instagram',
                    backgroundColor: 'rgba(255, 79, 145, 0.5)',
                    data: scheduled_post_charts_data.instagram
                }, {
                    label: 'Linkedin',
                    backgroundColor: 'rgba(28, 141, 217, 0.5)',
                    data: scheduled_post_charts_data.linkedin
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            };
            new Chart(scheduledStatisticsItem, {
                type: 'bar',
                data: data,
                options: options
            });
        }

        var todayStatisticsItem = $("#today_scheduled_post")[0];

        if (todayStatisticsItem) {
            var data = {
                labels: today_scheduled_post_charts_data.labels,
                datasets: [{
                    label: 'X/Twitter',
                    backgroundColor: 'rgba(0, 0, 0, 0.5)',
                    data: today_scheduled_post_charts_data.x
                }, {
                    label: 'Facebook',
                    backgroundColor: 'rgba(28, 155, 244, 0.5)',
                    data: today_scheduled_post_charts_data.facebook
                }, {
                    label: 'Instagram',
                    backgroundColor: 'rgba(255, 79, 145, 0.5)',
                    data: today_scheduled_post_charts_data.instagram
                }, {
                    label: 'Linkedin',
                    backgroundColor: 'rgba(28, 141, 217, 0.5)',
                    data: today_scheduled_post_charts_data.linkedin
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            };
            new Chart(todayStatisticsItem, {
                type: 'bar',
                data: data,
                options: options
            });
        }
    });

})(jQuery);