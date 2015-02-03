jQuery(document).ready(function(){

	if(document.getElementById('cmws-view')!=null){

		jQuery.ajax({
        		type: 'GET',
        		dataType: 'json',
        		url: '/wp-content/plugins/check-my-website/includes/api/check-my-website-metrics.php'
		})

		.done(function(data){

			if(document.getElementById('cmws-view-logs')!=null){

				

			}

			if(document.getElementById('cmws-view-metrics')!=null){

				self.xFormater = function(timestamp) {
					var date = new Date(timestamp);
					return date.toLocaleString();
				};

				self.yFormater = function(y, unit, decimals){
					if (y === 0)
						return 0;
					return Math.round(y, decimals) + ' '  + unit;
				};

				var urlId = data['global']['id'];

				var dataSet_httptime = [
					{
						color: '#ee5f5b',
						data: data['day']['series']['checks.'+urlId+'.httptime']['data'],
						fillColor: '#ee5f5b',
						hoverable: true,
						lines: { show: true, fill: true	},
						metric: 'httptime',
						threshold: [ { below: 500, color: '#5bc592' }, { below: 800, color: '#f89406' }	],
						unit: 'ms'
					}
				];

				var dataSet_state = [
                	        	{
						color: '#5bc592',
                        	    		data: data['day']['series']['checks.'+urlId+'.state.all']['data'],
						fillColor: '#5bc592',
						lines: { show: true, fill: true, zero: false },
						metric: 'availability',
						points: { show: true },
						threshold: [ { below: 90, color: '#ee5f5b' }, {	below: 95, color: '#f89406' } ],
						unit: '%'
                        		}
                		];

				var options_httptime = {
					grid: { hoverable: true, borderWidth: {top: 0, right: 0, bottom: 1, left: 1} },
					tooltip: true,
					tooltipOpts: {
						defaultTheme: false,
						content: function(metric, xval, yval, flotItem){
							var decimals = flotItem.series.decimals || 2;
							var unit = flotItem.series.unit || '';
							var tooltip = '';
							label = flotItem.series.metric;
							tooltip += '<b>' + self.xFormater(xval) + '</b>';
							tooltip += '<hr>';
							tooltip += self.yFormater(yval, unit, decimals);
							return tooltip;
						}
					},
					xaxis: { mode: 'time', timeformat: '%d/%m %H:%M' },
					yaxis: {
                                		min: 0,
						tickDecimals: 2,
						tickFormatter: function(val, axis) {
							var unit = axis.options.unit || '';
							var decimals = axis.options.tickDecimals || '';
							return self.yFormater(val, unit, decimals);
						},
						unit: 'ms'
                        		}
				};

				var options_state = {
					grid: { hoverable: true, borderWidth: {top: 0, right: 0, bottom: 1, left: 1} },
                	        	tooltip: true,
                        		tooltipOpts: {
                                		defaultTheme: false,
                                		content: function(metric, xval, yval, flotItem){
                                        		var decimals = flotItem.series.decimals || 2;
                                        		var unit = flotItem.series.unit || '';
                                        		var tooltip = '';
	                                        	label = flotItem.series.metric;
	                                        	tooltip += '<b>' + self.xFormater(xval) + '</b>';
        	                                	tooltip += '<hr>';
                	                        	tooltip += self.yFormater(yval, unit, decimals);
	                                        	return tooltip;
        	                        	}
                	        	},
					xaxis: { mode: 'time', timeformat: '%d/%m %H:%M' },
                        		yaxis: {
                                		max: 100,
						min: 0,
						tickDecimals: 2,
                                		tickFormatter: function(val, axis) {
                                        		var unit = axis.options.unit || '';
                                        		var decimals = axis.options.tickDecimals || '';
                                        		return self.yFormater(val, unit, decimals);
                                		},
                                		unit: '%'
                        		}
                		};

				function clearBox(elementID){ document.getElementById(elementID).innerHTML = ""; }

				if(data['metrics']){
	        			jQuery.plot(jQuery("#cmws-chart-httptime"), dataSet_httptime, options_httptime);
					jQuery.plot(jQuery("#cmws-chart-state"), dataSet_state, options_state);
					jQuery(window).resize(function() {jQuery.plot(jQuery('#cmws-chart-httptime'), dataSet_httptime, options_httptime);});
					jQuery(window).resize(function() {jQuery.plot(jQuery('#cmws-chart-state'), dataSet_state, options_state);});
				}

			}
		})
	}
});

