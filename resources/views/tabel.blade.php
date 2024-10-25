<x-layout.default>
    <script defer src="/assets/js/apexcharts.js"></script>

    <div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" x-data="chart">
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white">Simple Column</h5>
                    <a class="font-semibold hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-600"
                        href="javascript:;" @click="toggleCode('code3')"><span class="flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                <path
                                    d="M17 7.82959L18.6965 9.35641C20.239 10.7447 21.0103 11.4389 21.0103 12.3296C21.0103 13.2203 20.239 13.9145 18.6965 15.3028L17 16.8296"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path opacity="0.5" d="M13.9868 5L10.0132 19.8297" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M7.00005 7.82959L5.30358 9.35641C3.76102 10.7447 2.98975 11.4389 2.98975 12.3296C2.98975 13.2203 3.76102 13.9145 5.30358 15.3028L7.00005 16.8296"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Code
                        </span>
                    </a>
                </div>
                <div x-ref="columnChart" class="bg-white dark:bg-black rounded-lg overflow-hidden"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("chart", () => ({
                // highlightjs
                codeArr: [],
                toggleCode(name) {
                    if (this.codeArr.includes(name)) {
                        this.codeArr = this.codeArr.filter((d) => d != name);
                    } else {
                        this.codeArr.push(name);

                        setTimeout(() => {
                            document.querySelectorAll('pre.code').forEach(el => {
                                hljs.highlightElement(el);
                            });
                        });
                    }
                },

                columnChart: null,

                init() {
                    isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true :
                        false;
                    isRtl = this.$store.app.rtlClass === "rtl" ? true : false;

                    setTimeout(() => {
                        this.columnChart = new ApexCharts(this.$refs.columnChart, this
                            .columnChartOptions);
                        this.columnChart.render();
                    }, 300);

                    this.$watch('$store.app.theme', () => {
                        this.refreshOptions();
                    })

                    this.$watch('$store.app.rtlClass', () => {
                        this.refreshOptions();
                    })

                },

                refreshOptions() {
                    isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true :
                        false;
                    isRtl = this.$store.app.rtlClass === "rtl" ? true : false;
                    this.columnChart.updateOptions(this.columnChartOptions);
                },

                get columnChartOptions() {
                    return {
                        series: [{
                            name: 'Net Profit',
                            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                        }, {
                            name: 'Revenue',
                            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                        }],
                        chart: {
                            height: 300,
                            type: 'bar',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#805dca', '#e7515a'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        grid: {
                            borderColor: isDark ? '#191e3a' : '#e0e6ed'
                        },
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug',
                                'Sep', 'Oct'
                            ],
                            axisBorder: {
                                color: isDark ? '#191e3a' : '#e0e6ed'
                            },
                        },
                        yaxis: {
                            opposite: isRtl ? true : false,
                            labels: {
                                offsetX: isRtl ? -10 : 0,
                            }
                        },
                        tooltip: {
                            theme: isDark ? 'dark' : 'light',
                            y: {
                                formatter: function(val) {
                                    return val;
                                },
                            },
                        },
                    }
                },

                generateData(baseval, count, yrange) {
                    var i = 0;
                    var series = [];
                    while (i < count) {
                        var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
                        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                        var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

                        series.push([x, y, z]);
                        baseval += 86400000;
                        i++;
                    }
                    return series;
                }
            }));
        });
    </script>
</x-layout.default>
