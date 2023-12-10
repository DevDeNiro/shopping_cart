import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Product } from '../product.model';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent {
  constructor(private router: Router) { }
  products: Product[] = [
    { id: 1, name: 'Product 1', price: 10.99, description: 'This is product 1' },
    { id: 2, name: 'Product 2', price: 20.99, description: 'This is product 2' },
    { id: 3, name: 'Product 3', price: 30.99, description: 'This is product 3' },
    { id: 4, name: 'Product 4', price: 40.99, description: 'This is product 4' },
    { id: 5, name: 'Product 5', price: 50.99, description: 'This is product 5' },
    { id: 6, name: 'Product 6', price: 60.99, description: 'This is product 6' },
    { id: 7, name: 'Product 7', price: 70.99, description: 'This is product 7' },
    { id: 8, name: 'Product 8', price: 80.99, description: 'This is product 8' },
    { id: 9, name: 'Product 9', price: 90.99, description: 'This is product 9' },
    { id: 10, name: 'Product 10', price: 100.99, description: 'This is product 10' },
  ];
  totalItems = 0;
  addToCart(product: Product): void {
    this.totalItems++;
    console.log(product);
  }
  checkout() {
    // Navigate to the checkout page
    this.router.navigate(['/checkout']);
  }
}
