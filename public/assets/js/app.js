type = ['', 'info', 'success', 'warning', 'danger'];
$().ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

app = {
    checkFullPageBackgroundImage: function() {
        $page = $('.full-page');
        image_src = $page.data('image');

        if (image_src !== undefined) {
          image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
          $page.append(image_container);
        }
    },
    initFormExtendedDatetimepickers: function () {
        $('.datetimepicker').datetimepicker({
            icons:  {
                time:     "fa fa-clock-o",
                date:     "fa fa-calendar",
                up:       "fa fa-chevron-up",
                down:     "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next:     'fa fa-chevron-right',
                today:    'fa fa-screenshot',
                clear:    'fa fa-trash',
                close:    'fa fa-remove'
            },
            locale: 'zh_cn',
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',    //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons:  {
                time:     "fa fa-clock-o",
                date:     "fa fa-calendar",
                up:       "fa fa-chevron-up",
                down:     "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next:     'fa fa-chevron-right',
                today:    'fa fa-screenshot',
                clear:    'fa fa-trash',
                close:    'fa fa-remove'
            },
            locale: 'zh_cn'
        });

        $('.timepicker').datetimepicker({
//          format: 'H:mm',    // use this format if you want the 24hours timepicker
            format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons:  {
                time:     "fa fa-clock-o",
                date:     "fa fa-calendar",
                up:       "fa fa-chevron-up",
                down:     "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next:     'fa fa-chevron-right',
                today:    'fa fa-screenshot',
                clear:    'fa fa-trash',
                close:    'fa fa-remove'
            },
            locale: 'zh_cn'
        });
    },
    postData:            function (url, data, callback) {
        if (!url) {
            this.alertError('API地址错误，请联系管理员！！！');
            return false;
        }

        $.ajax({
            url:      url,
            type:     'post',
            dataType: 'json',
            data:     data,
            success:  function (res) {
                app.alertSuccess(res.message, true);
                if(typeof callback === "function") {
                    callback();
                }
            },
            error:    function (o, type, msg) {
                var message = (o.responseJSON && o.responseJSON.message && o.responseJSON.message !== "") ? o.responseJSON.message : msg;
                if (message && o && (o.responseJSON instanceof Object) && o.responseJSON.hasOwnProperty('errors')) {
                    app.alertValidatorError(o.responseJSON.errors, message)
                } else {
                    app.alertError(message)
                }

                if(typeof callback === "function") {
                    callback();
                }
            }
        });
    },
    alertError:          function (message) {
        message = message ? '原因：' + message : '';
        swal({
            type:               'error',
            title:              '提交失败',
            text:               message,
            confirmButtonClass: 'btn btn-success btn-fill',
            buttonsStyling:     false
        })
    },
    alertValidatorError: function (errors, message) {
        message         = message ? message : '错误原因：';
        var errors_html = '';
        $.each(errors, function (index, error) {
            if (error instanceof Array) {
                errors_html = error[0] + '<br/>'
            }
        });

        swal({
            type:               'error',
            title:              '提交失败',
            html:               message + '<br/>' + errors_html,
            confirmButtonClass: 'btn btn-success btn-fill',
            buttonsStyling:     false
        })
    },
    alertSuccess:        function (message, reload, text_or_html) {
        if (text_or_html === 'html') {
            swal({
                type:               'success',
                title:              '成功',
                html:               message,
                confirmButtonClass: 'btn btn-success btn-fill',
                buttonsStyling:     false
            }).then(function () {
                if (reload) {
                    location.reload();
                }
            })
        } else {
            swal({
                type:               'success',
                title:              '成功',
                text:               message,
                confirmButtonClass: 'btn btn-success btn-fill',
                buttonsStyling:     false
            }).then(function () {
                if (reload) {
                    location.reload();
                }
            })
        }
    },
    selffresh: function(page){
        html = "<select id='refresh'><option value='0'>不自动刷新</option><option value='30'>30秒</option><option value='60'>1分钟</option><option value='120'>2分钟</option><option value='300'>5分钟</option></select>"
        swal({
            title: '设置刷新',
            html: html,
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function (result) {
            timer = $('#refresh').val();
            window.localStorage.setItem(page+'fresh',$('#refresh').val());
            clearTimeout(t);
            if(timer==0){
                timer = 9999999999;
            }
            t=setTimeout(function () {
                window.location.reload();
            },timer*1000)
        })
    },
    showSwal: function(type,html,record_id,url) {
        html = html||'';
        record_id = record_id||'';
        if (type=='select-user') {
            swal({
                title: '分配用户',
                html: html,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function (result) {
                $.ajax({
                    data : {uid:$('#uid option:selected').val()},
                    type : 'POST',
                    url : url+'?id='+record_id,
                    success:function (data){
                        if(data.error == 200){
                            swal({
                                type: 'success',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false
                            }).catch(swal.noop);
                            window.location.reload();
                        }else{
                            swal({
                                type: 'error',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-error',
                                buttonsStyling: false
                            }).catch(swal.noop);
                        }
                    }
                })
            }).catch(swal.noop);
        }
        else if(type == 'confirm'){
            swal({
                title: '您确定吗!',
                text: html,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: '取消',
                confirmButtonText: '确定',
                buttonsStyling: false
            }).then(function (result) {
                $.ajax({
                    data : {id:record_id},
                    type : 'POST',
                    url : url,
                    success:function (data){
                        if(data.error == 200){
                            swal({
                                type: 'success',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false
                            }).catch(swal.noop);
                            window.location.reload();
                        }else{
                            swal({
                                type: 'error',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-error',
                                buttonsStyling: false
                            }).catch(swal.noop);
                        }
                    }
                })
            }).catch(swal.noop);
        }
        else if (type=='casechat') {
            swal({
                title: '沟通',
                html: html,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function (result) {
                console.log($("#replyform"));
                var formData = new FormData($("#replyform")[0]);
                $.ajax({
                    data : formData,
                    type : 'POST',
                    url : url+'?id='+record_id,
                    success:function (data){
                        if(data.error == 200){
                            swal({
                                type: 'success',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false
                            }).catch(swal.noop);
                            window.location.reload();
                        }else{
                            swal({
                                type: 'error',
                                html: data.msg,
                                confirmButtonClass: 'btn btn-error',
                                buttonsStyling: false
                            }).catch(swal.noop);
                        }
                    }
                })
            }).catch(swal.noop);
        }
    },
    initDashboardPageCharts: function(
                                        sharedhourData,sharedsevenData,sharedthirtyData,
                                        arrivedhourData,arrivedsevenData,arrivedthirtyData,
                                        registerhourData,registersevenData,registerthirtyData,
                                    ) 
    {
        sharedhourData = JSON.parse(sharedhourData);
        sharedsevenData = JSON.parse(sharedsevenData);
        sharedthirtyData = JSON.parse(sharedthirtyData);

        arrivedhourData = JSON.parse(arrivedhourData);
        arrivedsevenData = JSON.parse(arrivedsevenData);
        arrivedthirtyData = JSON.parse(arrivedthirtyData);

        registerhourData = JSON.parse(registerhourData);
        registersevenData = JSON.parse(registersevenData);
        registerthirtyData = JSON.parse(registerthirtyData);

        chartColor = "#FFFFFF";
        //24小时内签到 
        ctx = document.getElementById('arrivedCampaignChart').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#18ce0f');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#18ce0f', 0.4));

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: arrivedhourData.hour,
                datasets: [{
                    label: "Email Stats",
                    borderColor: "#ef8156",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    backgroundColor: gradientFill,
                    borderWidth: 3,
                    data: arrivedhourData.count,
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });
        // 24小时会议注册
        ctx = document.getElementById('registerCampaignChart').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#18ce0f');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#18ce0f', 0.4));

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: registerhourData.hour,
                datasets: [{
                    label: "Email Stats",
                    borderColor: "#ef8156",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    backgroundColor: gradientFill,
                    borderWidth: 3,
                    data: registerhourData.count,
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });

        // 24小时会议分享
        ctx = document.getElementById('emailsCampaignChart').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#18ce0f');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#18ce0f', 0.4));

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sharedhourData.hour,
                datasets: [{
                    label: "Email Stats",
                    borderColor: "#ef8156",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    backgroundColor: gradientFill,
                    borderWidth: 3,
                    data: sharedhourData.count,
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });

        // 7天内签到
        ctx = document.getElementById('arrivedUsers').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: arrivedsevenData.day,
                datasets: [{
                    label: "Active Users",
                    borderColor: "#6bd098",
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: arrivedsevenData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });
        // 7天内会议注册
        ctx = document.getElementById('registerUsers').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: registersevenData.day,
                datasets: [{
                    label: "Active Users",
                    borderColor: "#6bd098",
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: registersevenData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });

        // 7天内会议分享
        ctx = document.getElementById('activeUsers').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sharedsevenData.day,
                datasets: [{
                    label: "Active Users",
                    borderColor: "#6bd098",
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: sharedsevenData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        });
        
        // 30天内签到
        var e = document.getElementById("arrivedCountries").getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#2CA8FF');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#2CA8FF', 0.4));

        var a = {
            type: "line",
            data: {
                labels: arrivedthirtyData.day,
                datasets: [{
                    label: "Active Countries",
                    backgroundColor: gradientFill,
                    borderColor: "#fbc658",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: arrivedthirtyData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        };
        new Chart(e, a);
        // 30天内会议注册
        var e = document.getElementById("registerCountries").getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#2CA8FF');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#2CA8FF', 0.4));

        var a = {
            type: "line",
            data: {
                labels: registerthirtyData.day,
                datasets: [{
                    label: "Active Countries",
                    backgroundColor: gradientFill,
                    borderColor: "#fbc658",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: registerthirtyData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        };
        new Chart(e, a);

        // 30天内会议分享
        var e = document.getElementById("activeCountries").getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#2CA8FF');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, hexToRGB('#2CA8FF', 0.4));

        var a = {
            type: "line",
            data: {
                labels: sharedthirtyData.day,
                datasets: [{
                    label: "Active Countries",
                    backgroundColor: gradientFill,
                    borderColor: "#fbc658",
                    pointHoverRadius: 0,
                    pointRadius: 0,
                    fill: false,
                    borderWidth: 3,
                    data: sharedthirtyData.count
                }]
            },
            options: {

                legend: {

                    display: false
                },

                tooltips: {
                    enabled: false
                },

                scales: {
                    yAxes: [{

                        ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                        },
                        gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                        }

                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                        }
                    }]
                },
            }
        };

        var viewsChart = new Chart(e, a);

    }
};

