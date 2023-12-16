import { Injectable } from '@angular/core';
import { CartService } from './cart.service';
import { v4 as uuidv4 } from 'uuid';

@Injectable({
  providedIn: 'root'
})
export class SessionService {

  constructor(private cartService: CartService) { }

  checkSession(): void {
    let sessionId = localStorage.getItem('sessionId') || uuidv4();
    localStorage.setItem('sessionId', sessionId);

    this.cartService.getCart(sessionId).subscribe(
      cart => {
        console.log('Cart exists for this session', cart);
      },
      error => {
        if (error.status == 404) {
          this.cartService.createCart(sessionId).subscribe(
            newCart => {
              console.log('New cart created', newCart);
            },
            createCartError => {
              console.error('Error creating cart', createCartError);
            }
          );
        } else {
          console.error('Error getting cart', error);
        }
      }
    );
  }

  getSessionId(): string | null {
    return localStorage.getItem('sessionId');
  }
}