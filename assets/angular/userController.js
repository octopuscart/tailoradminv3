/* 
 Producrt list controllers
 */

Admin.controller('UserController', function ($scope, $http, $timeout, $interval) {

// custome profile related
    $scope.customizationDict = {'prestyle': {}, "has_pre_design": false};
    $scope.getUserDesings = function () {
        var url = adminurl + "/Api/getUserPreDesingByItem/" + user_id + "/" + item_id;
        $http.get(url).then(function (rdata) {
            $scope.customizationDict.prestyle = rdata.data.designs;
            console.log(rdata.data);
            $scope.customizationDict.has_pre_design = rdata.data.has_pre_design;
        });
    };
    $scope.getUserDesings();
    $scope.viewStyleOnly = function (style_name, custom_dict) {
        var styleobj = custom_dict;
        var customhtmlarray = [];
        for (i in styleobj) {
            var ks = styleobj[i].style_key;
            var kv = styleobj[i].style_value;
            console.log(kv);
            var checkdl = kv.indexOf("$");
            if (checkdl > -1) {
                var brkstr = kv.split(" ");
                var brkstrl = brkstr.length;
                var prestr = brkstr.splice(0, brkstrl - 1).join(" ");
                console.log(brkstr, brkstrl, prestr);
                var poststr = " <b class='extrapricesummry'>" + brkstr[0] + "</b>";
                console.log(poststr);
                var finalstr = prestr + poststr;
                var summaryhtml = "<tr><th>" + ks + "</th><td>" + finalstr + "</td></tr>";
            } else {
                var summaryhtml = "<tr><th>" + ks + "</th><td>" + kv + "</td></tr>";
            }
            customhtmlarray.push(summaryhtml);
        }
        customhtmlarray = customhtmlarray.join("");
        var customdiv = "<div class='custome_summary_popup'><table>" + customhtmlarray + "</table></div>";
        swal({
            title: style_name,
            html: customdiv,

            confirmButtonClass: 'btn btn-default',
        });
    }

    //end of custom profile

    //measurement profiles
    $scope.measurementsDict = {'premeasurements': {}, "has_pre_measurement": false};
    $scope.viewMeasurementOnly = function (style_name, custom_dict) {
        var styleobj = custom_dict;
        var customhtmlarray = [];
        for (i in styleobj) {
            var ks = styleobj[i].measurement_key;
            var kv = styleobj[i].measurement_value;
            var checkspace = kv.split(" ")[1];
            if (checkspace) {
                kv = " " + kv.replace(" ", "<span class='inchvaluemes'>") + "</span>";
            }
            var summaryhtml = "<tr><th>" + ks + "</th><td>" + kv + ' Inch</td></tr>';
            customhtmlarray.push(summaryhtml);
        }
        customhtmlarray = customhtmlarray.join("");
        var customdiv = "<div class='custome_summary_popup'><table>" + customhtmlarray + "</table></div>";
        swal({
            title: style_name,
            html: customdiv,
            confirmButtonClass: 'btn btn-default',
        });
    }

    $scope.getUserMeasurement = function () {
        var url = adminurl + "/Api/getUserPreMeasurementByItem/" + user_id + "/" + itemarrays;
        console.log(url);
        $http.get(url).then(function (rdata) {
            $scope.measurementsDict.premeasurements = rdata.data.measurement;
            console.log(rdata.data);
            $scope.measurementsDict.has_pre_measurement = rdata.data.has_pre_measurement;
        });
    };
    $scope.getUserMeasurement();
    //end of measurement profiles

    //news letters
    $scope.newsalertDict = {'listdata': {
            'Full Experience': {'title': 'Full Experience', 'description': 'I want the full Nita Fashions Experience.'},
            'Sales/Promotion': {'title': 'Sales/Promotion', 'description': 'I would like to only know about products that are on Sales/Promotion.'},
            'New Arrival': {'title': 'New Arrival', 'description': 'I would like to only know about products that are New/Trending.'},
            'Monthly': {'title': 'Monthly Subscription', 'description': 'I would like to receive monthly newsletters subscription from Nita Fashions.'},
            'Unsubscribe': {'title': 'Unsubscribe', 'description': 'I would like to unsubscribe newsletters from Nita Fashions.'},

        },
        'user_subscription': {"has_subscription": "no", "subscription_data": {}},
        'selected': "",
    };

    $scope.getUserSubscription = function () {
        var url = adminurl + "/Api/getUserSubscription/" + user_id;
        $http.get(url).then(function (rdata) {
            $scope.newsalertDict.user_subscription.has_subscription = rdata.data.has_subscription;
            $scope.newsalertDict.user_subscription.subscription_data = rdata.data.subscription_data;
        });
    };
    $scope.getUserSubscription();

    $scope.openModal = function () {
        $scope.newsalertDict.selected = "";
        $("#changeSubcription").modal("show");

    }



    $scope.askForSubscription = function (object) {
        $("#changeSubcription").modal("hide");

        swal({
            title: object.title,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            cancelButtonColor: 'red',
            confirmButtonText: 'Yes, Update',
            cancelButtonText: 'No, Cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
//            title: 'Adding to Cart',
            allowEscapeKey: false,
            allowOutsideClick: false,
            text: object.description,

            preConfirm: function (result) {

                swal({
                    title: 'Updating your settings.',
                    onOpen: function () {
                        swal.showLoading();
                    }
                });
                console.log($scope.newsalertDict.selected);

                $http.get(adminurl + "/Api/setUserSubscription/" + user_id + "/" + $scope.newsalertDict.selected).then(function (rdata) {
                    swal.close();
                    swal({
                        title: 'Subscription Updated',
                        type: 'success',
                        text: 'Your newsletter subcription has updated to ' + $scope.newsalertDict.selected,
                        imageWidth: 100,
                        timer: 1500,
                        imageAlt: 'Custom image',
                        showConfirmButton: false,
                        animation: true,
                        onClose: function () {
                            $scope.getUserSubscription();
                        }
                    })
                }, function () {
                    swal.close();
                    swal({
                        title: 'Something Wrong..',
                    })
                });
            },

        })
    }

    //end of newletter


})


