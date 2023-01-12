
<div id="canvas-holder-total" class="canvas-assets" style="width:100%">
    <canvas id="chart-assets-pietotal"></canvas>
</div>

<script>
    Chart.pluginService.register({
        beforeDraw: function(chart) {
            if (chart.config.options.elements.center) {
                // Get ctx from string
                var ctx = chart.chart.ctx;

                // Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var maxFontSize = centerConfig.maxFontSize || 75;
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                // Start with a base font of 30px
                ctx.font = "30px " + fontStyle;

                // Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(30 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
                var minFontSize = centerConfig.minFontSize;
                var lineHeight = centerConfig.lineHeight || 25;
                var wrapText = false;

                if (minFontSize === undefined) {
                    minFontSize = 20;
                }

                if (minFontSize && fontSizeToUse < minFontSize) {
                    fontSizeToUse = minFontSize;
                    wrapText = true;
                }

                // Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse + "px " + fontStyle;
                ctx.fillStyle = color;

                if (!wrapText) {
                    ctx.fillText(txt, centerX, centerY);
                    return;
                }

                var words = txt.split(' ');
                var line = '';
                var lines = [];

                // Break words up into multiple lines if necessary
                for (var n = 0; n < words.length; n++) {
                    var testLine = line + words[n] + ' ';
                    var metrics = ctx.measureText(testLine);
                    var testWidth = metrics.width;
                    if (testWidth > elementWidth && n > 0) {
                        lines.push(line);
                        line = words[n] + ' ';
                    } else {
                        line = testLine;
                    }
                }

                // Move the center up depending on line height and number of lines
                centerY -= (lines.length / 2) * lineHeight;

                for (var n = 0; n < lines.length; n++) {
                    ctx.fillText(lines[n], centerX, centerY);
                    centerY += lineHeight;
                }
                //Draw text in center
                ctx.fillText(line, centerX, centerY);
            }
        },
        afterLayout: function(chart) {
            let total = chart.data.datasets[0].data.reduce((a, b) => {
                return a + b;
            });
            chart.legend.legendItems.forEach(
                    (label) => {
                        let value = chart.data.datasets[0].data[label.index];
                        label.text += ': ' + value;
                        return label;
                    }
            )
        }
    });

    var configPieTotal = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [<{$assetsTotal_data}>],
                backgroundColor: [
                    <{foreach item=pcolor from=$assetsTotal_pcolors}>
                        window.chartColors.<{$pcolor}>,
                    <{/foreach}>
                ],
                label: 'Dataset 1'
            }],
            labels: [<{$assetsTotal_labels}>]
        },
        options: {
            elements: {
                center: {
                    text: '<{$assetsTotal_total}>',
                            color: '#000000', // Default is #000000
                            fontStyle: 'Arial', // Default is Arial
                            sidePadding: 20, // Default is 20 (as a percentage)
                            minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
                            lineHeight: 25 // Default is 25 (in px), used for when text wraps
                }
            },

            responsive: true,

            legend: {
                display: <{$assetsTotal_displaylegend}>,
                position: 'right',
                labels: {boxWidth:20, fontSize:15},
            },
            title: {
                display: true,
                text: '<{$smarty.const._MA_WGSIMPLEACC_ASSETS}>'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    window.onload = function() {
        var ctx_pietotal = document.getElementById('chart-assets-pietotal').getContext('2d');
        window.myDoughnutTotal = new Chart(ctx_pietotal, configPieTotal);
    };

</script>