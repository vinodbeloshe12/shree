import { Component, OnInit } from '@angular/core';
import { ChartOptions, ChartType, ChartDataSets } from 'chart.js';
import { Label } from 'ng2-charts';
import { UserService } from '../service/user.service';
import * as moment from 'moment';
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

  public barChartLabels: Label[] = [];
  public barChartType: ChartType = 'bar';
  public barChartLegend = true;
  dashboardData: any;
  emidue: any;
  stockList: any = [];
  salesList: any = [];
  emiList: any = [];


  public barChartData: ChartDataSets[] = [
    { data: [], label: 'Purchase', backgroundColor: '#0c9aa9', borderColor: '#fff', hoverBackgroundColor: '#29c9da', hoverBorderColor: '#0c9aa9', barPercentage: 5, barThickness: 10, maxBarThickness: 15, minBarLength: 2, },
    { data: [], label: 'Sales', backgroundColor: '#333333', borderColor: '#fff', hoverBackgroundColor: '#666666', hoverBorderColor: '#333333', barPercentage: 5, barThickness: 10, maxBarThickness: 15, minBarLength: 2, },

  ];
  constructor(private userService: UserService) {
    const today = moment();
    this.barChartLabels = Array(6).fill(today, 0, 6).map(
      () => today.subtract(1, 'd').format('YYYY-MM-DD')
    ).reverse();
    this.barChartLabels.push(moment().format('YYYY-MM-DD'));
    this.emidue = Array(6).fill(today, 0, 6).map(
      () => today.add(1, 'd').format('DD')
    ).reverse();
  }

  ngOnInit() {

    this.getDashboardDetails();
    this.getEMIDetails(this.emidue);
    this.getChartData(this.barChartLabels);
    this.getAllSales();
  }

  getDashboardDetails() {
    this.userService.getDashboardDetails().subscribe((res: any) => {
      this.dashboardData = res.data;
      // console.log("asdasd", this.dashboardData)
    })
  }

  getEMIDetails(days) {
    this.userService.getEMIDetails(days).subscribe((res: any) => {
      if (res.value == true) {
        // console.log("in")
        this.emiList = res.data;
      }
      // console.log("out",res)
    })
  }

  getChartData(dates) {
    // console.log("dates",dates);
    this.userService.getChartData(dates).subscribe((res: any) => {
      // this.dashboardData = res.data;
      if (res.value) {
        this.barChartData[0].data = res.purchase;
        this.barChartData[1].data = res.sale;
      }
      // console.log("chartdata", res)
    })
  }

  // events
  public chartClicked({ event, active }: { event: MouseEvent, active: {}[] }): void {
    console.log(event, active);
  }

  public chartHovered({ event, active }: { event: MouseEvent, active: {}[] }): void {
    console.log(event, active);
  }

  getAllSales() {
    this.userService.getAllSales().subscribe((res: any) => {
      this.salesList = res.data;
    })
  }

  // public randomize(): void {
  //   // Only Change 3 values
  //   const data = [
  //     Math.round(Math.random() * 100),
  //     59,
  //     80,
  //     (Math.random() * 100),
  //     56,
  //     (Math.random() * 100),
  //     40];
  //   this.barChartData[0].data = data;
  // }
}
