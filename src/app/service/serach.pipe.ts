import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
  name: 'customerFilter'
})
export class SearchPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (!args) {
      return value;
    } else {
      args = args.toLocaleLowerCase();
    }
    return value.filter((val) => {
      let rVal = (val.name.toLocaleLowerCase().includes(args)) || (val.email.toLocaleLowerCase().includes(args)) || (val.mobile.toLocaleLowerCase().includes(args)) || (val.Pancard ? val.Pancard.toLocaleLowerCase().includes(args) : '') || (val.aadharcard ? val.aadharcard.toLocaleLowerCase().includes(args) : '');
      return rVal;
    })

  }

}