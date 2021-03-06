import 'dart:io';
import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:share_learning/models/api_status.dart';
// import 'package:share_learning/models/book.dart';
import 'package:share_learning/models/session.dart';
import 'package:share_learning/templates/managers/strings_manager.dart';
import 'package:share_learning/templates/managers/values_manager.dart';

class SessionApi {
  static Future<Object> postSession(String userName, String password) async {
    try {
      Map<String, String> postBody = {
        "username": userName,
        "password": password
      };
      // var url = Uri.parse('http://localhost/apiforsharelearn/sessions');
      var url = Uri.parse('http://10.0.2.2/apiforsharelearn/sessions');

      // Map<String, String> postHeaders = {
      // "Content-Type": "application/json; charset=utf-8",
      // "Content-Type": "application/json",
      // HttpHeaders.contentTypeHeader: "application/json; charset=utf-8",
      // HttpHeaders.contentTypeHeader: "application/json",
      // };

      var response = await http.post(
        url,
        // headers: postHeaders,
        headers: {
          // HttpHeaders.authorizationHeader:
          //     'Mzk0YTM2ZWZhZGQ1ZjY2MDQwZmMxMWZkNGE4MzRjMmM2M2FhMTNhY2M1ZDhlYTEyMzEzNjM0MzIzOTM1MzAzMjM1MzA=',
          // "Accept": "application/json",
          "Accept": "application/json; charset=utf-8",
          // "Accept": "application/json; charset=UTF-8",
          "Access-Control-Allow-Origin":
              "*", // Required for CORS support to work
          "Access-Control-Allow-Methods": "POST, GET, OPTIONS",
          // "Content-Type": "application/json; charset=utf-8",
          // "Content-Type": "application/json; charset=utf-8",
          // "Content-Type": "application/json",
          // HttpHeaders.contentTypeHeader: "application/json; charset=utf-8",
          HttpHeaders.contentTypeHeader: "application/json",
        },
        body: json.encode(postBody),
      );

      print(postBody);

      print(json.encode(json.decode(response.body)));

      if (response.statusCode == ApiStatusCode.responseSuccess) {
        return Success(
            code: response.statusCode,
            response: sessionFromJson(
                json.encode(json.decode(response.body)['data']['sessions'])));
      }
      return Failure(
          code: ApiStatusCode.invalidResponse,
          errorResponse: ApiStrings.invalidResponseString);
    } on HttpException {
      return Failure(
          code: ApiStatusCode.httpError,
          errorResponse: ApiStrings.noInternetString);
    } on FormatException {
      return Failure(
          code: ApiStatusCode.invalidResponse,
          errorResponse: ApiStrings.invalidFormatString);
    } catch (e) {
      // return Failure(code: 103, errorResponse: e.toString());
      return Failure(
          code: ApiStatusCode.unknownError,
          errorResponse: ApiStrings.unknownErrorString);
    }
  }
}
