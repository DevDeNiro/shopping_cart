import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from '../services/cart.service';
import { SessionService } from '../services/session.service';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.scss']
})
export class CheckoutComponent implements OnInit {
  totalItems = 0;
  totalPrice = 0.00;
  sessionId: string | null = null;

  constructor(
    private cartService: CartService,
    private sessionService: SessionService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.sessionId = this.sessionService.getSessionId();
    this.getCartDetails();
  }

  getCartDetails() {
    if (this.sessionId) {
      this.cartService.getCartDetails(this.sessionId).subscribe(
        cart => {
          this.totalItems = cart.products.length;
          this.totalPrice = cart.products.reduce((total: number, product: { price: number, quantity: number }) => total + product.price * product.quantity, 0);
        }
      );
    }
  }
  checkout() {
    if (this.sessionId) {
      this.cartService.checkout(this.sessionId).subscribe(
        () => {
          this.router.navigate(['/thankyou']);
        }
      );
    }
  }
}