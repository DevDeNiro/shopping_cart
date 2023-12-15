import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Product } from '../product.model';
import { ProductService } from '../product.service';
import { CartService } from '../cart.service';
import { v4 as uuidv4 } from 'uuid';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit{
  products: Product[] = [];
  constructor(private router: Router, private productService: ProductService,  private cartService: CartService) { }
  ngOnInit() {
    this.getProducts();
    let sessionId = localStorage.getItem('sessionId');
    if (!sessionId) {
      sessionId = uuidv4();
      localStorage.setItem('sessionId', sessionId);
    }
  
    this.cartService.getCart(sessionId).subscribe(
      cart => {
        // If a cart exists for the session, use it.
        console.log('Cart exists for this session', cart);
      },
      error => {
        // If no cart exists for the session, create a new one.
        if (error.status == 404) {
          if (sessionId) {
            this.cartService.createCart(sessionId).subscribe(
              newCart => {
                console.log('New cart created', newCart);
              },
              createCartError => {
                console.error('Error creating cart', createCartError);
              }
            );
          } else {
            console.error('Session ID is null');
          }
        } else {
          console.error('Error getting cart', error);
        }
      }
    );
  }
  getProducts(): void {
    this.productService.getProducts().subscribe(products => this.products = products);
  }
  
  totalItems = 0;
  addToCart(product: any): void {
    this.totalItems++;
    const sessionId = localStorage.getItem('sessionId');
    if (sessionId) {
      this.cartService.addToCart(sessionId, product.id.value, 1).subscribe();
    } else {
      console.error('Session ID is null');
    }
  }
  checkout() {
    this.router.navigate(['/checkout']);
  }
}