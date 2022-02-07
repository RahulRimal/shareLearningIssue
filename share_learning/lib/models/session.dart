// To parse this JSON data, do
//
//     final session = sessionFromJson(jsonString);

import 'dart:convert';

List<Session> sessionFromJson(String str) =>
    List<Session>.from(json.decode(str).map((x) => Session.fromJson(x)));

String sessionToJson(List<Session> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class Session {
  Session({
    required this.id,
    required this.userId,
    required this.accessToken,
    required this.accessTokenExpiry,
    required this.refreshToken,
    required this.refreshTokenExpiry,
  });

  String id;
  String userId;
  String accessToken;
  DateTime accessTokenExpiry;
  String refreshToken;
  DateTime refreshTokenExpiry;

  factory Session.fromJson(Map<String, dynamic> json) => Session(
        id: json["id"] == null ? null : json["id"],
        userId: json["userId"] == null ? null : json["userId"],
        accessToken: json["accessToken"] == null ? null : json["accessToken"],
        // accessTokenExpiry: json["accessTokenExpiry"] == null ? null : DateTime.parse(json["accessTokenExpiry"]),
        accessTokenExpiry: DateTime.parse(json["accessTokenExpiry"]),
        refreshToken:
            json["refreshToken"] == null ? null : json["refreshToken"],
        // refreshTokenExpiry: json["refreshTokenExpiry"] == null ? null : DateTime.parse(json["refreshTokenExpiry"]),
        refreshTokenExpiry: DateTime.parse(json["refreshTokenExpiry"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id == null ? null : id,
        "userId": userId == null ? null : userId,
        "accessToken": accessToken == null ? null : accessToken,
        "accessTokenExpiry": accessTokenExpiry == null
            ? null
            : accessTokenExpiry.toIso8601String(),
        "refreshToken": refreshToken == null ? null : refreshToken,
        "refreshTokenExpiry": refreshTokenExpiry == null
            ? null
            : refreshTokenExpiry.toIso8601String(),
      };
}

class CustomSessionError {
  int code;
  Object message;

  CustomSessionError({required this.code, required this.message});
}
