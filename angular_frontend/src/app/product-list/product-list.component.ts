import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Product } from '../models/product.model';
import { ProductService } from '../services/product.service';
import { CartService } from '../services/cart.service';
import { SessionService } from '../services/session.service';
import { SharedService } from '../services/shared.service';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit {
  products: Product[] = [];
  sessionId: string | null = null;


  constructor(
    private router: Router,
    private productService: ProductService,
    private cartService: CartService,
    private sessionService: SessionService,
    private sharedService: SharedService
  ) { }
  ngOnInit() {
    this.getProducts();
    this.sessionService.checkSession();
    this.sessionId = localStorage.getItem('sessionId');
  }
  getProducts(): void {
    this.productService.getProducts().subscribe(products => this.products = products);
  }

  addToCart(product: any): void {
    if (this.sessionId) {
      this.cartService.addToCart(this.sessionId, product.id.value, 1).subscribe(
        () => {
          this.sharedService.getCartDetails();
        },
        error => {
          console.error('Error adding to cart', error);
        }
      );
    } else {
      console.error('Session ID is null');
    }
  }

  goToCart() {
    this.router.navigate(['/cart']);
  }
}