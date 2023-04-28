/**
 * Used for single line scripts.
 */

const MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

export function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = 0; i < count; ++i) {
        value = MONTHS[Math.ceil(i) % 12];
        values.push(value.substring(0, section));
    }

    return values;
}

export const CHART_COLORS = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

const NAMED_COLORS = [
    CHART_COLORS.red,
    CHART_COLORS.orange,
    CHART_COLORS.yellow,
    CHART_COLORS.green,
    CHART_COLORS.blue,
    CHART_COLORS.purple,
    CHART_COLORS.grey,
];

export function transparentize(value, opacity) {
    var alpha = opacity === undefined ? 0.5 : 1 - opacity;
    return colorLib(value).alpha(alpha).rgbString();
}
export function numbers(config) {
    var cfg = config || {};
    var min = valueOrDefault(cfg.min, 0);
    var max = valueOrDefault(cfg.max, 100);
    var from = valueOrDefault(cfg.from, []);
    var count = valueOrDefault(cfg.count, 8);
    var decimals = valueOrDefault(cfg.decimals, 8);
    var continuity = valueOrDefault(cfg.continuity, 1);
    var dfactor = Math.pow(10, decimals) || 0;
    var data = [];
    var i, value;

    for (i = 0; i < count; ++i) {
        value = (from[i] || 0) + this.rand(min, max);
        if (this.rand() <= continuity) {
            data.push(Math.round(dfactor * value) / dfactor);
        } else {
            data.push(null);
        }
    }

    return data;
}


const ctx = document.getElementById('vulnsPerApp').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['CodeIgniter', 'Symfony', 'Slim', 'CakePHP', 'Laravel'],
        datasets: [{
            label: '# Vulnerabilities',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(201, 203, 207, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(201, 203, 207, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const labels = months({count: 5});
const data = {
    labels: labels,
    datasets: [{
        label: 'Vulnerabilities per month',
        data: [13, 5, 22, 12, 14, 1, 5],
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};
const config = {
    type: 'line',
    data: data,
};

const vulnsPerMonthCtx = document.getElementById('vulnsPerMonth').getContext('2d');
const vulnsPerMonth = new Chart(vulnsPerMonthCtx, config)


const vulnsPerTypeConfig = {
    type: 'doughnut',
    data: {
        labels: [
            'SQL Injection',
            'Local/Remote File Inclusion',
            'Command Injection'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [55, 33, 12],
            backgroundColor: [
                CHART_COLORS.green,
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    }
};

const vulnsPerType = new Chart(
    document.getElementById('vulnsPerType').getContext('2d')
    , vulnsPerTypeConfig)




const NUMBER_CFG = {count: 7, min: 0, max: 30};

const data3 = {
    labels: ['SQL Injection', 'Command Injection', 'Local/Remote File Inclusion'],
    datasets: [
        {
            label: 'Symfony',
            data: [1, 5,3],
            borderColor: CHART_COLORS.grey,
            backgroundColor: 'rgba(203, 207, 201, 0.3)',
        },
        {
            label: 'CodeIgniter',
            data: [5,2,3],
            borderColor: CHART_COLORS.blue,
            backgroundColor: 'rgba(54, 162, 235, 0.3)'
        },

        {
            label: 'CakePHP',
            data: [1,4,3],
            borderColor: CHART_COLORS.orange,
            backgroundColor: 'rgba(255, 159, 64, 0.3)'
        },

        {
            label: 'Laravel',
            data: [3,2,3],
            borderColor: CHART_COLORS.yellow,
            backgroundColor: 'rgba(255, 205, 86, 0.3)'
        },

        {
            label: 'Slim',
            data: [4,2,6],
            borderColor: CHART_COLORS.green,
            backgroundColor: 'rgba(75, 192, 192, 0.3)'
        },

    ]
};

const vulnsPerApplicationConfig = {
    type: 'radar',
    data: data3,
    options: {
        responsive: true,
        plugins: {
        }
    },
};

const vulnsPerApplication = new Chart(
    document.getElementById('vulnsPerApplication').getContext('2d')
    , vulnsPerApplicationConfig)

