import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BrandstockComponent } from './brandstock.component';

describe('BrandstockComponent', () => {
  let component: BrandstockComponent;
  let fixture: ComponentFixture<BrandstockComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BrandstockComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BrandstockComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
