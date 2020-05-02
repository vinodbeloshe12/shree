import { Component, OnInit } from '@angular/core';
import { ChartOptions, ChartType, ChartDataSets } from 'chart.js';
import { Label } from 'ng2-charts';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.less']
})
export class DashboardComponent implements OnInit {
  public barChartOptions: ChartOptions = {
    responsive: true,
    legend: {
      display: true,
      position: 'bottom',
      labels: {
        fontColor: '#333',
        boxWidth: 15,
        padding: 20,
        fontFamily: "'Saira', sans-serif",

      }
    },
    // We use these empty structures as placeholders for dynamic theming.
    scales: { xAxes: [{}], yAxes: [{}] },
    plugins: {
      datalabels: {
        anchor: 'end',
        align: 'end',
      }
    }
  };

  public barChartLabels: Label[] = ['18-4-2020', '19-4-2020', '20-4-2020', '21-4-2020', '22-4-2020', 'Yesterday', 'Today'];
  public barChartType: ChartType = 'bar';
  public barChartLegend = true;

  public barChartData: ChartDataSets[] = [
    { data: [65, 59, 81, 70, 56, 55, 40], label: 'Purchase', backgroundColor: '#0c9aa9', borderColor: '#fff', hoverBackgroundColor: '#29c9da', hoverBorderColor: '#0c9aa9', barPercentage: 5, barThickness: 10, maxBarThickness: 15, minBarLength: 2, },
    { data: [28, 48, 40, 66, 50, 44, 38], label: 'Sales', backgroundColor: '#333333', borderColor: '#fff', hoverBackgroundColor: '#666666', hoverBorderColor: '#333333', barPercentage: 5, barThickness: 10, maxBarThickness: 15, minBarLength: 2, },

  ];
  constructor() { }

  ngOnInit() {
  }
  // events
  public chartClicked({ event, active }: { event: MouseEvent, active: {}[] }): void {
    console.log(event, active);
  }

  public chartHovered({ event, active }: { event: MouseEvent, active: {}[] }): void {
    console.log(event, active);

  }

  public randomize(): void {
    // Only Change 3 values
    const data = [
      Math.round(Math.random() * 100),
      59,
      80,
      (Math.random() * 100),
      56,
      (Math.random() * 100),
      40];
    this.barChartData[0].data = data;
  }
}
