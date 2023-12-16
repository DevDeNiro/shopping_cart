import { Injectable } from '@angular/core';
import { CartService } from './cart.service';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SharedService {
  totalItems = new BehaviorSubject<number>(0);
  totalItems$ = this.totalItems.asObservable();
  sessionId: string | null = null;
  constructor(
    private cartService: CartService
  ) { }
  getCartDetails(): void {
    this.sessionId = localStorage.getItem('sessionId');
    if (this.sessionId) {
      this.cartService.getCartDetails(this.sessionId).subscribe(
        cart => {
          const total = cart.products.reduce((total: number, product: { quantity: number }) => total + product.quantity, 0);
          this.totalItems.next(total);
        },
        error => {
          console.error('Error getting cart details', error);
        }
      );
    } else {
      console.error('Session ID is null');
    }
  }
}
