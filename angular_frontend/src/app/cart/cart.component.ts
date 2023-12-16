import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from '../services/cart.service';
import { SessionService } from '../services/session.service';
import { CartItem } from '../models/cartItem.model';
import { SharedService } from '../services/shared.service';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.scss']
})
export class CartComponent implements OnInit {
  products: CartItem[] = [];
  sessionId: string | null = null;

  constructor(
    private router: Router,
    private cartService: CartService,
    private sessionService: SessionService,
    private sharedService: SharedService
  ) { }

  ngOnInit() {
    this.sessionId = this.sessionService.getSessionId();
    this.getCartDetails();
  }

  getCartDetails() {
    if (this.sessionId) {
      this.cartService.getCartDetails(this.sessionId).subscribe(
        cart => this.products = cart.products
      );
    }
  }

  updateQuantity(cartItemId: string, change: number) {
    const product = this.products.find(product => product.cartItemId === cartItemId);
    if (product) {
      product.quantity += change;
      if (this.sessionId) {
        this.cartService.updateCartItem(this.sessionId, cartItemId, change).subscribe(
          () => this.sharedService.getCartDetails()
        );
      }
    }
  }

  deleteProduct(cartItemId: string) {
    if (this.sessionId) {
      this.cartService.removeFromCart(this.sessionId, cartItemId).subscribe(
        () => {
          this.getCartDetails();
          this.sharedService.getCartDetails();
        }
      );
    }
  }

  getTotalPrice() {
    return this.products.reduce((total, product) => total + product.price * product.quantity, 0);
  }

  checkout() {
    this.router.navigate(['/checkout']);
  }
}