import { Component, OnInit } from '@angular/core';
import { SharedService } from '../services/shared.service';


@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {
  totalItems: number = 10;
  sessionId: string | null = null;

  constructor(private sharedService: SharedService) { }

  ngOnInit(): void {
    this.sharedService.getCartDetails();
    this.sharedService.totalItems$.subscribe(
      total => this.totalItems = total
    );
  }
}
