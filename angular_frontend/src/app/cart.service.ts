import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../environments/environment';
import { Observable } from 'rxjs';
import { Product } from './product.model';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) { }

  createCart(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.post(`${this.apiUrl}/cart`, {}, { headers });
  }

  getCart(sessionId: string): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.get(`${this.apiUrl}/cart`, { headers });
  }

  addToCart(sessionId: string, productId: string, quantity: number): Observable<any> {
    const headers = { 'X-Session-Id': sessionId };
    return this.http.post(`${this.apiUrl}/cart/items`, { productId, quantity }, { headers });
  }

  removeFromCart(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/cart/items/${id}`);
  }

  updateCartItem(id: number, quantity: number): Observable<any> {
    return this.http.put(`${this.apiUrl}/cart/items/${id}`, { quantity });
  }

  checkout(cartId: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/cart/checkout`, { cartId });
  }
}