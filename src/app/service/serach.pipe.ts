import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
  name: 'customerFilter'
})
export class SearchPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (!args) {
      return value;
    }
    return value.filter((val) => {
      let rVal = (val.name.toLocaleLowerCase().includes(args)) || (val.email.toLocaleLowerCase().includes(args)) || (val.mobile.toLocaleLowerCase().includes(args)) || (val.pancard?val.pancard.toLocaleLowerCase().includes(args):'') || (val.adharcard?val.adharcard.toLocaleLowerCase().includes(args):'');
      return rVal;
    })

  }

}