


import ApexCharts from '../thirdparty/apexchartsWrapper.js';
import { PeityAPI } from './../thirdparty/peity.es6.js';


// Control Center Dashboard
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /***************************************************************/
    /* Script for the area chart with live updates but no animation*/
    /***************************************************************/

    // Generate initial random data with natural patterns
    const generateData = (count) => {
        const data = [];
        let value = 50; // Start from middle
        for (let i = 0; i < count; i++) {
            // Create more natural movements with smaller changes
            const change = (Math.random() - 0.5) * 8; // Smaller random changes
            value = Math.min(Math.max(value + change, 10), 90); // Keep within bounds
            data.push(Math.round(value));
        }
        return data;
    };

    // Area Chart
    const areaChartOptions = {
        series: [{
            name: 'Activity',
            data: generateData(180)
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            animations: {
                enabled: false
            },
            parentHeightOffset: 0,
            sparkline: {
                enabled: false
            }
        },
        colors: [window.colorMap.primary[500].hex],
        dataLabels: {
            enabled: false
        },
        tooltip: {
            enabled: true,
            followCursor: true
        },
        stroke: {
            curve: 'straight',
            width: 1.5,
            colors: [window.colorMap.primary[500].hex]
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 95, 100],
                colorStops: [
                    {
                        offset: 0,
                        color: window.colorMap.primary[500].hex,
                        opacity: 0.4
                    },
                    {
                        offset: 100,
                        color: window.colorMap.primary[500].hex,
                        opacity: 0.1
                    }
                ]
            }
        },
        grid: {
            show: true,
            borderColor: window.colorMap.bootstrapVars.bodyColor.rgba(0.08),
            strokeDashArray: 5,
            position: 'back',
            padding: {
                left: -5,
                right: 0,
                top: -20,
                bottom: -5
            },
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        xaxis: {
            type: 'numeric',
            tickAmount: 10,
            labels: {
                style: {
                    colors: window.colorMap.bootstrapVars.bodyColor.rgba(0.5),
                    fontSize: '10px',
                },
                show: true,
                offsetX: 10
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            min: 0,
            max: 100,
            tickAmount: 5,
            show: true,
            labels: {
                style: {
                    colors: window.colorMap.bootstrapVars.bodyColor.rgba(0.5),
                    fontSize: '10px',
                },
                formatter: function (value) {
                    return value;
                },
                show: true,
                offsetX: -15,
                align: 'left'
            }
        },
        legend: {
            show: false
        }
    };

    // Initialize the chart
    const areaChart = new ApexCharts(
        document.querySelector('#apex-chart-1'),
        areaChartOptions
    );
    areaChart.render();

    // Create and add the live update checkbox
    const controlDiv = document.createElement('div');
    controlDiv.className = 'mb-0 position-relative';
    controlDiv.innerHTML = `
        <div class="form-check form-switch position-absolute z-1" style="top: 1.5rem; left: 2.5rem;">
            <input class="form-check-input" type="checkbox" id="liveUpdateCheck">
            <label class="form-check-label" for="liveUpdateCheck">
                Live Update
            </label>
        </div>
    `;
    document.querySelector('#apex-chart-1').parentNode.insertBefore(controlDiv, document.querySelector('#apex-chart-1'));

    // Live update functionality with smoother transitions
    let updateInterval;
    const checkbox = document.querySelector('#liveUpdateCheck');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            // Start live updates
            updateInterval = setInterval(() => {
                const currentData = areaChart.w.config.series[0].data;
                const lastValue = currentData[currentData.length - 1];
                const change = (Math.random() - 0.5) * 8;
                const newValue = Math.round(Math.min(Math.max(lastValue + change, 10), 90));

                const newData = [...currentData.slice(1), newValue];
                areaChart.updateSeries([{
                    data: newData
                }], true);
            }, 1000);
        } else {
            // Stop live updates
            clearInterval(updateInterval);
        }
    });



    /***************************************************************/
    /* Script for the calendar                                     */
    /***************************************************************/

    const eventData = [
        { id: '1', title: 'Team Meeting', start: new Date(new Date().setHours(10, 0)), end: new Date(new Date().setHours(11, 30)), backgroundColor: 'var(--primary-500)', borderColor: 'var(--primary-600)', description: 'Weekly team status meeting', location: 'Conference Room A' },
        { id: '2', title: 'Client Call', start: new Date(new Date().setDate(new Date().getDate() + 1)), allDay: true, backgroundColor: 'var(--success-500)', borderColor: 'var(--success-600)', description: 'Quarterly review with major client', location: 'Zoom Meeting' },
        { id: '3', title: 'Product Launch', start: new Date(new Date().setDate(new Date().getDate() + 3)), end: new Date(new Date().setDate(new Date().getDate() + 3)).setHours(15, 0), backgroundColor: 'var(--danger-500)', borderColor: 'var(--danger-600)', description: 'New product launch event', location: 'Main Auditorium' },
        { id: '4', title: 'Deadline: Q3 Report', start: new Date(new Date().setDate(new Date().getDate() + 5)), allDay: true, backgroundColor: 'var(--warning-500)', borderColor: 'var(--warning-600)', description: 'Submit quarterly financial reports', location: 'Finance Department' },
        { id: '5', title: 'Training Session', start: new Date(new Date().setDate(new Date().getDate() - 2)), end: new Date(new Date().setDate(new Date().getDate() - 2)).setHours(16, 0), backgroundColor: 'var(--info-500)', borderColor: 'var(--info-600)', description: 'New software training for all employees', location: 'Training Room B' },
        { id: '6', title: 'Board Meeting', start: new Date(new Date().setDate(new Date().getDate() + 7)), allDay: true, backgroundColor: 'var(--danger-500)', borderColor: 'var(--danger-700)', description: 'Annual board meeting with stakeholders', location: 'Executive Boardroom' },
        { id: '7', title: 'Website Maintenance', start: new Date(new Date().setDate(new Date().getDate() - 1)).setHours(23, 0), end: new Date(new Date().setDate(new Date().getDate())).setHours(5, 0), backgroundColor: 'var(--info-500)', borderColor: 'var(--info-600)', description: 'Scheduled website maintenance window', location: 'IT Department' },
        { id: '8', title: 'Team Building', start: new Date(new Date().setDate(new Date().getDate() + 12)), end: new Date(new Date().setDate(new Date().getDate() + 12)).setHours(16, 0), backgroundColor: 'var(--primary-300)', borderColor: 'var(--primary-400)', description: 'Annual team building activities', location: 'City Park' },
        { id: '9', title: 'Client Dinner', start: new Date(new Date().setDate(new Date().getDate() + 4)).setHours(19, 0), end: new Date(new Date().setDate(new Date().getDate() + 4)).setHours(21, 0), backgroundColor: 'var(--success-300)', borderColor: 'var(--success-400)', description: 'Dinner with potential investors', location: 'Downtown Restaurant' },
        { id: '10', title: 'Vacation', start: new Date(new Date().setDate(new Date().getDate() + 14)), end: new Date(new Date().setDate(new Date().getDate() + 21)), backgroundColor: 'var(--bs-teal)', borderColor: 'var(--bs-teal)', description: 'Annual vacation time', location: 'Beach Resort' },
        { id: '11', title: 'Marketing Campaign', start: new Date(new Date().setDate(new Date().getDate() + 2)), end: new Date(new Date().setDate(new Date().getDate() + 2)).setHours(17, 0), backgroundColor: 'var(--bs-purple)', borderColor: 'var(--bs-purple)', description: 'Launch new product marketing campaign', location: 'Marketing Department', category: 'marketing' },
        { id: '12', title: 'Sales Meeting', start: new Date(new Date().setDate(new Date().getDate() + 3)).setHours(9, 0), end: new Date(new Date().setDate(new Date().getDate() + 3)).setHours(10, 30), backgroundColor: 'var(--success-600)', borderColor: 'var(--success-700)', description: 'Monthly sales team catchup', location: 'Conference Room B', category: 'sales' },
        { id: '13', title: 'Development Sprint Review', start: new Date(new Date().setDate(new Date().getDate() + 6)).setHours(14, 0), end: new Date(new Date().setDate(new Date().getDate() + 6)).setHours(16, 0), backgroundColor: 'var(--bs-indigo)', borderColor: 'var(--bs-indigo)', description: 'End of sprint review with stakeholders', location: 'Dev Team Area', category: 'development' },
        { id: '14', title: 'Tech Conference', start: new Date(new Date().setDate(new Date().getDate() + 8)), end: new Date(new Date().setDate(new Date().getDate() + 10)), backgroundColor: 'var(--bs-indigo)', borderColor: 'var(--bs-indigo)', description: 'Annual tech conference for industry professionals', location: 'Convention Center', category: 'conference' },
        { id: '15', title: 'Dentist Appointment', start: new Date(new Date().setDate(new Date().getDate() + 2)).setHours(14, 0), end: new Date(new Date().setDate(new Date().getDate() + 2)).setHours(15, 0), backgroundColor: 'var(--warning-500)', borderColor: 'var(--warning-600)', description: 'Routine dental checkup', location: 'Downtown Clinic', category: 'personal' },
        { id: '16', title: 'Project Milestone: Beta Release', start: new Date(new Date().setDate(new Date().getDate() + 15)), allDay: true, backgroundColor: 'var(--success-500)', borderColor: 'var(--success-600)', description: 'Beta release of the new app', location: 'Development Team', category: 'development' },
        { id: '17', title: 'Company Announcement', start: new Date(new Date().setDate(new Date().getDate() + 1)).setHours(11, 0), end: new Date(new Date().setDate(new Date().getDate() + 1)).setHours(11, 30), backgroundColor: 'var(--primary-500)', borderColor: 'var(--primary-600)', description: 'Announcement of new company policies', location: 'Main Hall', category: 'announcement' },
        { id: '18', title: 'Weekly Team Sync', start: new Date(new Date().setDate(new Date().getDate() + 4)).setHours(9, 0), end: new Date(new Date().setDate(new Date().getDate() + 4)).setHours(9, 30), backgroundColor: 'var(--primary-400)', borderColor: 'var(--primary-500)', description: 'Recurring weekly sync for project updates', location: 'Meeting Room C', category: 'team', extendedProps: { recurrence: 'weekly' } }
    ];

    // Initialize the calendar
    const calendarEl = document.getElementById('myCalendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
        headerToolbar: {
            right: 'today prev,next',
            left: 'title'
        },
       
        footerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day',
            list: 'List'
        },
        dayMaxEvents: 2, // Show only 2 events per day, then show "more" link
        height: '760px', // Set minimum height for desktop
        eventSources: [
            { events: eventData }
        ]
    });
    calendar.render();

    /***************************************************************/
    /* Script to display current day, month, year                  */
    /***************************************************************/

    const currentDate = new Date();
    const day = currentDate.getDate();
    const month = currentDate.getMonth() + 1; // Months are 0-based
    const year = currentDate.getFullYear();

    //document.querySelector('.currentDate').innerHTML = `${day} ${month} ${year}`;

    /***************************************************************/
    /* Subscription Chart                                          */
    /***************************************************************/

    // Generate hourly data for subscriptions
    const generateHourlyData = () => {
        const today = [
            { x: '3am', y: 0 },
            { x: '4am', y: 0 },
            { x: '5am', y: 5000 },
            { x: '6am', y: 7500 },
            { x: '7am', y: 12000 },
            { x: '8am', y: 22500 },
            { x: '9am', y: 27000 },
            { x: '10am', y: 37500 },
            { x: '11am', y: 35000 },
            { x: '12m', y: 37500 },
            { x: '1pm', y: 9500 },
            { x: '2pm', y: 0 },
            { x: '3pm', y: 0 },
            { x: '4pm', y: 0 },
            { x: '5pm', y: 0 }
        ];

        const yesterday = [
            { x: '3am', y: 0 },
            { x: '4am', y: 0 },
            { x: '5am', y: 0 },
            { x: '6am', y: 5500 },
            { x: '7am', y: 15000 },
            { x: '8am', y: 20000 },
            { x: '9am', y: 35000 },
            { x: '10am', y: 30500 },
            { x: '11am', y: 35000 },
            { x: '12m', y: 27500 },
            { x: '1pm', y: 42500 },
            { x: '2pm', y: 32500 },
            { x: '3pm', y: 37500 },
            { x: '4pm', y: 27500 },
            { x: '5pm', y: 17500 }
        ];

        return {
            today: today,
            yesterday: yesterday
        };
    };

    const hourlyData = generateHourlyData();

    const subscriptionChartOptions = {
        series: [{
            name: 'Today',
            data: hourlyData.today
        }, {
            name: 'Yesterday',
            data: hourlyData.yesterday
        }],
        chart: {
            height: '100%',
            maxHeight: 275,
            width: '100%',
            type: 'bar',
            toolbar: {
                show: false
            },
            sparkline: {
                enabled: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '70%',
                endingShape: 'rounded',
                borderRadius: 0,
            }
        },
        colors: [window.colorMap.success[500].hex, window.colorMap.bootstrapVars.bodyColor.rgba(0.7)],
        dataLabels: {
            enabled: false
        },
        grid: {
            show: true,
            borderColor: window.colorMap.bootstrapVars.bodyColor.rgba(0.08),
            strokeDashArray: 5,
            position: 'back',
            padding: {
                left: -5,
                right: 0,
                top: -20,
                bottom: -5
            },
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            type: 'category',
            labels: {
                style: {
                    colors: '#8e8da4',
                    fontSize: '10px'
                },
                show: true
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            min: 0,
            max: 50000,
            tickAmount: 4,
            labels: {
                style: {
                    colors: '#8e8da4',
                    fontSize: '10px'
                },
                formatter: function (value) {
                    return '$' + Math.floor(value / 1000) + 'k';
                },
                show: true,
                offsetX: -15,
                align: 'left'
            }
        },
        tooltip: {
            enabled: true,
            followCursor: true,
            theme: 'dark',
            y: {
                formatter: function (value) {
                    return '$' + value.toLocaleString();
                }
            }
        },
        legend: {
            show: false
        }
    };

    // Initialize the subscriptions chart
    const subscriptionsChart = new ApexCharts(
        document.querySelector('#subscriptionsChart'),
        subscriptionChartOptions
    );
    subscriptionsChart.render();

    /***************************************************************/
    /* Secession Chart                                             */
    /***************************************************************/

    // Calculate total for percentages
    const populationData = [
        { label: "Current Usage", value: 4119630000, color: window.colorMap.primary[500].hex },
        { label: "Net Usage", value: 590950000, color: window.colorMap.info[500].hex },
        { label: "Users Blocked", value: 1012960000, color: window.colorMap.warning[500].hex },
        { label: "Custom Cases", value: 95100000, color: window.colorMap.danger[500].hex },
        { label: "Test Logs", value: 727080000, color: window.colorMap.success[500].hex },
        { label: "Uptime Records", value: 344120000, color: window.colorMap.bootstrapVars.bodyColor.rgba(0.7) }
    ];

    const total = populationData.reduce((sum, item) => sum + item.value, 0);

    const secessionChartOptions = {
        series: populationData.map(item => item.value),
        chart: {
            type: 'donut',
            height: '100%',
            maxHeight: 275,
            width: '100%'
        },
        colors: populationData.map(item => item.color),
        plotOptions: {
            pie: {
                donut: {
                    size: '50%'
                }
            }
        },
        labels: populationData.map(item => item.label),
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        tooltip: {
            enabled: false,
            y: {
                formatter: function (value) {
                    // Calculate percentage
                    const percentage = ((value / total) * 100).toFixed(1);
                    // Format the population number with commas
                    const population = value.toLocaleString();
                    return `${percentage}% (${population})`;
                }
            }
        },
        stroke: {
            width: 0
        }
    };

    // Initialize the secession chart
    const secessionChart = new ApexCharts(
        document.querySelector('#secessionChart'),
        secessionChartOptions
    );
    secessionChart.render();

    window.updateMiscPluginColors = function () {
        // No miscellaneous plugins requiring color updates
    };


    /***************************************************************/
    /* Script for PeityCharts                                      */
    /***************************************************************/
    // Global default settings for charts
    const defaults = {
        // Default background color for donut and pie charts (replaces the gray)
        donutBackground: 'var(--bs-border-color)', // Light purple background instead of gray
        pieBackground: 'var(--bs-border-color)'    // Same for pie charts
    };

    // Helper to create peity charts (similar to jQuery plugin style)
    function createPeity(selector, type, customOptions = {}) {
        document.querySelectorAll(selector).forEach(element => {
            // Parse data-peity attribute for options
            let options = { ...customOptions };
            const dataAttr = element.getAttribute('data-peity');

            if (dataAttr) {
                try {
                    options = { ...options, ...JSON.parse(dataAttr) };
                } catch (e) {
                    console.warn('Invalid data-peity format for', selector);
                }
            }

            // Apply defaults for donut and pie charts background colors
            if (type === 'donut' || type === 'pie') {
                // If fill is not defined or is an empty array, set default colors
                if (!options.fill || options.fill.length === 0) {
                    options.fill = type === 'donut' ?
                        ['var(--primary-500)', defaults.donutBackground] :
                        ['var(--primary-500)', defaults.pieBackground];
                }
                // If fill is defined but doesn't include a background color (for fractions like "1/4")
                else if (Array.isArray(options.fill) && options.fill.length === 1) {
                    options.fill.push(type === 'donut' ? defaults.donutBackground : defaults.pieBackground);
                }
                // If data contains multiple values (e.g., "10,4,4,6"), don't add background
            }

            PeityAPI.create(element, type, options);
        });
    }

    try {
        // Simple chart initializations with default settings
        createPeity('.peity-pie', 'pie');
        createPeity('.peity-donut', 'donut');
        createPeity('.peity-line', 'line');
        createPeity('.peity-bar', 'bar');

        // Updating chart with animation
        const updatingChart = document.querySelector('.updating-chart');
        if (updatingChart) {
            const values = updatingChart.textContent.split(',').map(Number);
            const chart = PeityAPI.create(updatingChart, 'line', {
                width: 200,
                height: 40,
                stroke: 'var(--info-500)',
                fill: 'var(--info-200)',
                min: 0,
                max: 10
            });

            setInterval(function () {
                values.shift();
                values.push(Math.floor(Math.random() * 10));
                updatingChart.textContent = values.join(',');
                chart.draw();
            }, 500);
        }

        // Bar charts with negative values (red/green coloring)
        document.querySelectorAll('.bar-negative').forEach(element => {
            const values = element.textContent.split(',').map(Number);
            PeityAPI.create(element, 'bar', {
                height: 40,
                width: 110,
                fill: values.map(value => value > 0 ? 'var(--success-500)' : 'var(--danger-500)')
            });
        });

        // Bar charts with color transitions
        document.querySelectorAll('.bar-transition').forEach(element => {
            const values = element.textContent.split(',').map(Number);
            PeityAPI.create(element, 'bar', {
                height: 40,
                width: 110,
                fill: values.map((_, i, all) => {
                    const g = parseInt((i / all.length) * 255);
                    return `rgb(255, ${g}, ${g})`;
                })
            });
        });

        // Process all remaining elements with data-peity attribute
        document.querySelectorAll('[data-peity]').forEach(element => {
            // Skip elements already handled by specific selectors
            if (element.classList.contains('peity-pie') ||
                element.classList.contains('peity-donut') ||
                element.classList.contains('peity-line') ||
                element.classList.contains('peity-bar') ||
                element.classList.contains('updating-chart') ||
                element.classList.contains('bar-negative') ||
                element.classList.contains('bar-transition')) {
                return;
            }

            // Auto-detect chart type based on content
            const content = element.textContent.trim();
            let type;

            if (content.includes('/')) {
                type = 'donut'; // Fraction data is best for donut
            } else if (content.includes(',')) {
                // If it has commas, it's likely a series
                const hasNegative = content.split(',').some(val => parseFloat(val) < 0);
                type = hasNegative ? 'bar' : 'line'; // Bars handle negative values better visually
            } else {
                type = 'pie'; // Default fallback
            }

            // Get options from data attribute
            let options = {};
            const dataAttr = element.getAttribute('data-peity');
            if (dataAttr) {
                try {
                    options = JSON.parse(dataAttr);
                } catch (e) {
                    console.warn('Invalid data-peity format for element', element);
                }
            }

            // Apply global background color for donut/pie charts
            if ((type === 'donut' || type === 'pie') && content.includes('/')) {
                // For fraction notation (e.g. "1/4"), make sure we have a background color
                if (!options.fill || !Array.isArray(options.fill) || options.fill.length < 2) {
                    options.fill = options.fill || [];
                    // If we have one color already, keep it and add the background
                    if (options.fill.length === 1) {
                        options.fill.push(type === 'donut' ? defaults.donutBackground : defaults.pieBackground);
                    } else {
                        // No colors defined yet, set defaults
                        options.fill = [
                            type === 'donut' ? 'var(--primary-500)' : 'var(--success-500)',
                            type === 'donut' ? defaults.donutBackground : defaults.pieBackground
                        ];
                    }
                }
            }

            // Create chart
            PeityAPI.create(element, type, options);
        });

    } catch (error) {
        console.error('Error initializing Peity charts:', error);
    }

    /***************************************************************/
    /* Script for EasyPieCharts                                    */
    /***************************************************************/
    // Create and initialize easy pie charts
    // function initEasyPieCharts() {
    //     document.querySelectorAll('.js-easy-pie-chart').forEach(function(element) {
    //         // Skip if chart is already initialized
    //         if (element._easyPieChart) return;

    //         // Get element properties using vanilla JS
    //         const computedStyle = window.getComputedStyle(element);
    //         const barcolor = element.dataset.barcolor || computedStyle.color || 'var(--primary-700)';

    //         // Check if window.colorMap exists, if not use a fallback
    //         let trackcolor;
    //         try {
    //             if (window.colorMap && window.colorMap.bootstrapVars && window.colorMap.bootstrapVars.bodyColorRgb) {
    //                 trackcolor = window.colorMap.bootstrapVars.bodyColorRgb.rgba(0.07);
    //             } else {
    //                 trackcolor = 'rgba(0,0,0,0.04)';
    //             }
    //         } catch (e) {
    //             trackcolor = 'rgba(0,0,0,0.04)';
    //         }

    //         // Read dataset attributes with fallbacks
    //         const size = parseInt(element.dataset.piesize) || 50;
    //         const scalecolor = element.dataset.scalecolor || computedStyle.color || 'var(--primary-700)';
    //         const scalelength = parseInt(element.dataset.scalelength) || 0;
    //         const linewidth = parseInt(element.dataset.linewidth) || parseInt(size / 8.5);
    //         const linecap = element.dataset.linecap || 'butt'; // butt, round and square.

    //         // Create EasyPieChart instance
    //         const chart = new EasyPieChart(element, {
    //             size: size,
    //             barColor: barcolor,
    //             trackColor: trackcolor,
    //             scaleColor: scalecolor,
    //             scaleLength: scalelength,
    //             lineCap: linecap,
    //             lineWidth: linewidth,
    //             animate: {
    //                 duration: 1500,
    //                 enabled: true
    //             },
    //             easing: 'easeOutQuad', // Use our built-in easing function
    //             onStep: function(from, to, percent) {
    //                 // Find the percentage element and update its text
    //                 const percentElement = element.querySelector('.js-percent');
    //                 if (percentElement) {
    //                     percentElement.textContent = Math.round(percent);
    //                 }
    //             }
    //         });

    //         // Store the original percent value for rebuilds
    //         if (element.dataset.percent) {
    //             element._originalPercent = parseFloat(element.dataset.percent);
    //         } else if (element.getAttribute('data-percent')) {
    //             element._originalPercent = parseFloat(element.getAttribute('data-percent'));
    //         }
    //     });
    // }

    // // Destroy all existing charts
    // function destroyEasyPieCharts() {
    //     document.querySelectorAll('.js-easy-pie-chart').forEach(function(element) {
    //         if (element._easyPieChart) {
    //             element._easyPieChart.destroy();
    //         }
    //     });
    // }

    // // Rebuild all charts with current theme colors
    // window.rebuildEasyPieCharts = function() {
    //     destroyEasyPieCharts();
    //     initEasyPieCharts();
    // };

    // // Initialize easy pie charts
    // initEasyPieCharts();
});